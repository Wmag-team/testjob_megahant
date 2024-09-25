<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->getUsers($request->all());
        return response()->json($users);
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->userService->getUser($id);
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return response()->json($user);
    }

    public function softDelete(string $id): JsonResponse
    {
        $this->userService->softDeleteUser($id);
        return response()->json(['message' => 'User moved to trash']);
    }

    public function trashed(): JsonResponse
    {
        $trashedUsers = $this->userService->getTrashedUsers();
        return response()->json($trashedUsers);
    }

    public function restore(string $id): JsonResponse
    {
        $this->userService->restoreUser($id);
        return response()->json(['message' => 'User restored']);
    }

    public function forceDelete(string $id): JsonResponse
    {
        $this->userService->forceDeleteUser($id);
        return response()->json(['message' => 'User permanently deleted']);
    }

    public function bulkSoftDelete(Request $request): JsonResponse
    {
        $ids = $request->validate(['ids' => 'required|array'])['ids'];
        $this->userService->bulkSoftDeleteUsers($ids);
        return response()->json(['message' => 'Users moved to trash']);
    }

    public function bulkForceDelete(Request $request): JsonResponse
    {
        $ids = $request->validate(['ids' => 'required|array'])['ids'];
        $this->userService->bulkForceDeleteUsers($ids);
        return response()->json(['message' => 'Users permanently deleted']);
    }

    public function bulkRestore(Request $request): JsonResponse
    {
        $ids = $request->validate(['ids' => 'required|array'])['ids'];
        $this->userService->bulkRestoreUsers($ids);
        return response()->json(['message' => 'Users restored']);
    }
}
