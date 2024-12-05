<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
/**
 * @OA\Get(
 *         path="/api/user/books/{user}",
 *         summary="Книга арендованная пользователем",
 *         tags={"User"},
 *
 *         @OA\Parameter(
 *             description="ID пользователя",
 *             in="path",
 *             name="user",
 *             required=true,
 *             example=1
 *         ),
 *
 *         @OA\Response(
 *             response=200,
 *             description="OK",
 *             @OA\JsonContent(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="title", type="string", example="Some title"),
 *                 @OA\Property(property="author_id", type="integer", example=1),
 *                 @OA\Property(property="published_at", type="date", example="2012-11-25"),
 *                 @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                 @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                ),
 *         ),
 *         @OA\Response(
 *            response=404,
 *            description="Not Found",
 *         ),
 *     ),
 */
class UserController extends Controller
{
    public function books(User $user): JsonResponse
    {
        return response()->json($user->books);
    }
}
