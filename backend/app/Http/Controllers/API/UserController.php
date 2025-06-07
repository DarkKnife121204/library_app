<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function store(UserStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        User::create($validated);

        return response()->json(['message' => 'Пользователь успешно зарегистрирован'], 201);
    }
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }
    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $validated = $request->validated();
        $user->update($validated);
        return new UserResource($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
