<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
/**
 * @OA\Get(
 *       path="/api/authors",
 *       summary="Список",
 *       tags={"Authors"},
 *
 *       @OA\Response(
 *           response=200,
 *           description="OK",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array",@OA\Items(
 * *                     @OA\Property(property="id", type="integer", example=1),
 * *                     @OA\Property(property="name", type="string", example="name"),
 * *                     @OA\Property(property="bio", type="string", example="bio"),
 * *                     @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 * *                     @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 * *              )),
 *           ),
 *       ),
 *   ),
 *
 * @OA\Post(
 *     path="/api/authors",
 *     summary="Создание",
 *     tags={"Authors"},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(ref="#/components/schemas/AuthorStoreRequestSchema")
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="OK",
 *         @OA\JsonContent(
 *              @OA\Property(property="data", type="object",
 * *                     @OA\Property(property="id", type="integer", example=1),
 * *                     @OA\Property(property="name", type="string", example="name"),
 * *                     @OA\Property(property="bio", type="string", example="bio"),
 * *                     @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 * *                     @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 * *              ),
 *         ),
 *     ),
 * ),
 *
 * @OA\Get(
 *       path="/api/authors/{author}",
 *       summary="Просмотр",
 *       tags={"Authors"},
 *
 *       @OA\Parameter(
 *           description="ID автора",
 *           in="path",
 *           name="author",
 *           required=true,
 *           example=1
 *       ),
 *
 *       @OA\Response(
 *           response=200,
 *           description="OK",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="name"),
 *                     @OA\Property(property="bio", type="string", example="bio"),
 *                     @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                     @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *              ),
 *          ),
 *       ),
 *       @OA\Response(
 *           response=404,
 *           description="Not Found",
 *       ),
 *   ),
 *
 * @OA\Patch(
 *        path="/api/authors/{author}",
 *        summary="Обновление",
 *        tags={"Authors"},
 *
 *        @OA\Parameter(
 *            description="ID автора",
 *            in="path",
 *            name="patсh",
 *            required=true,
 *            example=1
 *        ),
 *
 *        @OA\RequestBody(
 *            @OA\JsonContent(
 *                allOf={
 *                    @OA\Schema(ref="#/components/schemas/AuthorUpdateRequestSchema")
 *                }
 *            )
 *        ),
 *
 *        @OA\Response(
 *            response=200,
 *            description="OK",
 *            @OA\JsonContent(
 *                @OA\Property(property="data", type="object",
 *                      @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="name", type="string", example="name"),
 *                      @OA\Property(property="bio", type="string", example="bio"),
 *                      @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                      @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                ),
 *            ),
 *       ),
 *       @OA\Response(
 *           response=404,
 *           description="Not Found",
 *       ),
 *    ),
 *
 * @OA\Delete(
 *        path="/api/authors/{author}",
 *        summary="Удалить",
 *        tags={"Authors"},
 *
 *        @OA\Parameter(
 *            description="ID автора",
 *            in="path",
 *            name="destroy",
 *            required=true,
 *            example=1
 *        ),
 *
 *        @OA\Response(
 *            response=200,
 *            description="OK",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Author deleted successfully"),
 *           ),
 *        ),
 *        @OA\Response(
 *            response=404,
 *            description="Not Found",
 *        ),
 *    ),
 *
 * @OA\Get(
 *         path="/api/authors/books/{author}",
 *         summary="Книги автора",
 *         tags={"Authors"},
 *
 *         @OA\Parameter(
 *             description="ID автора",
 *             in="path",
 *             name="author",
 *             required=true,
 *             example=1
 *         ),
 *
 *         @OA\Response(
 *             response=200,
 *             description="OK",
 *             @OA\JsonContent( type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="title", type="string", example="Some title"),
 *                 @OA\Property(property="author_id", type="integer", example=1),
 *                 @OA\Property(property="published_at", type="date", example="2012-11-25"),
 *                 @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                 @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                )),
 *         ),
 *         @OA\Response(
 *            response=404,
 *            description="Not Found",
 *         ),
 *     ),
 */
class AuthorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return AuthorResource::collection(Author::all());
    }

    public function show(Author $author): AuthorResource
    {
        return AuthorResource::make($author);
    }
    public function store(AuthorStoreRequest $request) : AuthorResource
    {
        $validated = $request->validated();
        $author = Author::create($validated);
        return new AuthorResource($author);
    }
    public function update(AuthorUpdateRequest $request, Author $author): AuthorResource
    {
        $validated = $request->validated();
        $author->update($validated);
        return new AuthorResource($author);
    }

    public function destroy(Author $author): JsonResponse
    {
        $author->delete();
        return response()->json([
            'message' => 'Author deleted successfully'
        ]);
    }

    public function books(Author $author): JsonResponse
    {
        return response()->json($author->books);
    }
}
