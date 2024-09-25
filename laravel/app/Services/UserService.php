<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $this->historyService->logAction($user->id, 'User', [], $user->toArray(), 'created');
        return $user;
    }

    public function getUsers(array $filters)
    {
        $query = User::query();

        if (isset($filters['sort'])) {
            $query->orderBy($filters['sort'], $filters['order'] ?? 'asc');
        }

        foreach ($filters as $field => $value) {
            if (!in_array($field, ['sort', 'order', 'page', 'per_page'])) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function getUser(string $id): User
    {
        return Cache::remember("user:{$id}", 3600, function () use ($id) {
            return User::findOrFail($id);
        });
    }

    public function updateUser(string $id, array $data): User
    {
        $user = $this->getUser($id);
        $before = $user->toArray();
        $user->update($data);
        $this->historyService->logAction($user->id, 'User', $before, $user->toArray(), 'updated');
        Cache::forget("user:{$id}");
        return $user;
    }

    public function softDeleteUser(string $id): void
    {
        $user = $this->getUser($id);
        $before = $user->toArray();
        $user->delete();
        $this->historyService->logAction($user->id, 'User', $before, $user->toArray(), 'soft_deleted');
        Cache::forget("user:{$id}");
    }

    public function getTrashedUsers()
    {
        return User::onlyTrashed()->get();
    }

    public function restoreUser(string $id): void
    {
        $user = User::withTrashed()->findOrFail($id);
        $before = $user->toArray();
        $user->restore();
        $this->historyService->logAction($user->id, 'User', $before, $user->toArray(), 'restored');
        Cache::forget("user:{$id}");
    }

    public function forceDeleteUser(string $id): void
    {
        $user = User::withTrashed()->findOrFail($id);
        $before = $user->toArray();
        $user->forceDelete();
        $this->historyService->logAction($user->id, 'User', $before, [], 'force_deleted');
        Cache::forget("user:{$id}");
    }

    public function bulkSoftDeleteUsers(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            foreach ($ids as $id) {
                $this->softDeleteUser($id);
            }
        });
    }

    public function bulkForceDeleteUsers(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            foreach ($ids as $id) {
                $this->forceDeleteUser($id);
            }
        });
    }

    public function bulkRestoreUsers(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            foreach ($ids as $id) {
                $this->restoreUser($id);
            }
        });
    }
}
