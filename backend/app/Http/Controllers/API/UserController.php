<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Mail\PasswordUpdated;
use App\Models\Rental;
use App\Models\reservation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }
    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }
    public function store(UserStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);

        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован',
            'data' => new UserResource($user)
        ], 201);
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        $user->update($validated);

        return response()->json([
            'message' => 'Пользователь успешно обновлён',
            'data' => new UserResource($user)
        ], 200);
    }

    public function setPassword(UserPasswordRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        $newPassword = $validated['password'];
        $user->password = Hash::make($newPassword);
        $user->save();

        Mail::to($user->email)->send(new PasswordUpdated($newPassword, $user->name));

        return response()->json(['message' => 'Пароль обновлён и отправлен на email'], 200);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json([
            'message' => 'Пользователь успешно удалён'
        ], 200);
    }

    public function reservations(User $User): JsonResponse
    {
        return response()->json($User->reservations);
    }
}
