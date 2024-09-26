<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="users",
 *     description="User management"
 * )
 */
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/users",
     *     tags={"users"},
     *     summary="Get list of users",
     *     @OA\Response(
     *         response=200,
     *         description="List of users"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->getUsers($request->all());
        return response()->json($users);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     tags={"users"},
     *     summary="Get user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userService->getUser($id);
        return response()->json($user);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"users"},
     *     summary="Update user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated"
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     tags={"users"},
     *     summary="Soft delete user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User moved to trash"
     *     )
     * )
     */
    public function softDelete(string $id): JsonResponse
    {
        $this->userService->softDeleteUser($id);
        return response()->json(['message' => 'User moved to trash']);
    }

    /**
     * @OA\Get(
     *     path="/users/trashed",
     *     tags={"users"},
     *     summary="Get trashed users",
     *     @OA\Response(
     *         response=200,
     *         description="List of trashed users"
     *     )
     * )
     */
    public function trashed(): JsonResponse
    {
        $trashedUsers = $this->userService->getTrashedUsers();
        return response()->json($trashedUsers);
    }

    /**
     * @OA\Post(
     *     path="/users/{id}/restore",
     *     tags={"users"},
     *     summary="Restore trashed user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *              @OA\Schema(type="string")
     *      ),
     *       @OA\Response(
     *           response=200,
     *           description="User restored"
     *       )
     *  )
     */
    public function restore(string $id): JsonResponse
    {
        $this->userService->restoreUser($id);
        return response()->json(['message' => 'User restored']);
    }

    /**
     * @OA\Delete(
     *      path="/users/{id}/force",
     *      tags={"users"},
     *      summary="Force delete user by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="User ID",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User permanently deleted"
     *      )
     * )
     */
    public function forceDelete(string $id): JsonResponse
    {
        $this->userService->forceDeleteUser($id);
        return response()->json(['message' => 'User permanently deleted']);
    }

    /**
     * @OA\Post(
     *      path="/users/bulk-soft-delete",
     *      tags={"users"},
     *      summary="Bulk soft delete users",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="ids", type="array", @OA\Items(type="string"))
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Users moved to trash"
     *      )
     * )
     */
    public function bulkSoftDelete(Request $request): JsonResponse
    {
        $ids = $request->validate(['ids' => 'required|array'])['ids'];
        $this->userService->bulkSoftDeleteUsers($ids);
        return response()->json(['message' => 'Users moved to trash']);
    }

    /**
    * @OA\Post(
    *      path="/users/bulk-force-delete",
    *      tags={"users"},
    *      summary="Bulk force delete users",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(property="ids", type="array", @OA\Items(type="string"))
    *          )
    *      ),
    *       @OA\Response(
    *           response=200,
    *           description="Users permanently deleted"
    *       )
    *)
    */
    public function bulkForceDelete(Request $request): JsonResponse
    {
        $ids = $request->validate(['ids' => 'required|array'])['ids'];
        $this->userService->bulkForceDeleteUsers($ids);
        return response()->json(['message' => 'Users permanently deleted']);
    }

    /**
     * @OA\Post(
     *   path="/users/bulk-restore",
     *   tags={"users"},
     *   summary="Bulk restore users",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="ids", type="array", @OA\Items(type="string"))
     *       )
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Users restored"
     *   )
     *)
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $ids = $request->validate(['ids' => 'required|array'])['ids'];
        $this->userService->bulkRestoreUsers($ids);
        return response()->json(['message' => 'Users restored']);
    }
}
