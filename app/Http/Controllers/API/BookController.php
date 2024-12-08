<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
/**
 * @OA\Get(
 *       path="/api/books",
 *       summary="Список",
 *       tags={"Books"},
 *
 *       @OA\Response(
 *           response=200,
 *           description="OK",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(
 *                   @OA\Property(property="id", type="integer", example=1),
 *                   @OA\Property(property="title", type="string", example="Some title"),
 *                   @OA\Property(property="author_id", type="integer", example=12),
 *                   @OA\Property(property="published_at", type="date", example="1994-09-03"),
 *                   @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                   @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *               )),
 *           ),
 *       ),
 *   ),
 *
 * @OA\Post(
 *     path="/api/books",
 *     summary="Создание",
 *     tags={"Books"},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={@OA\Schema(ref="#/components/schemas/BookStoreRequestSchema")}
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                    @OA\Property(property="id", type="integer", example=1),
 *                    @OA\Property(property="title", type="string", example="title"),
 *                    @OA\Property(property="author_id", type="integer", example=1),
 *                    @OA\Property(property="published_at", type="date", example="2024-12-12"),
 *                    @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                    @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *             ),
 *         ),
 *     ),
 * ),
 *
 * @OA\Get(
 *       path="/api/books/{books}",
 *       summary="Просмотр",
 *       tags={"Books"},
 *
 *       @OA\Parameter(
 *           description="ID книги",
 *           in="path",
 *           name="book",
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
 *                     @OA\Property(property="title", type="string", example="Some title"),
 *                     @OA\Property(property="author_id", type="integer", example=1),
 *                     @OA\Property(property="published_at", type="date", example="2024-12-12"),
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
 *        path="/api/books/{books}",
 *        summary="Обновление",
 *        tags={"Books"},
 *
 *        @OA\Parameter(
 *            description="ID книги",
 *            in="path",
 *            name="patсh",
 *            required=true,
 *            example=1
 *        ),
 *
 *        @OA\RequestBody(
 *            @OA\JsonContent(
 *                allOf={@OA\Schema(ref="#/components/schemas/BookUpdateRequestSchema")}
 *            )
 *        ),
 *
 *        @OA\Response(
 *            response=200,
 *            description="OK",
 *            @OA\JsonContent(
 *                @OA\Property(property="data", type="object",
 *                      @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="title", type="string", example="title"),
 *                      @OA\Property(property="author_id", type="integer", example=1),
 *                      @OA\Property(property="published_at", type="date", example="2024-12-12"),
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
 *        path="/api/books/{books}",
 *        summary="Удалить",
 *        tags={"Books"},
 *
 *        @OA\Parameter(
 *            description="ID книги",
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
 *               @OA\Property(property="message", type="string", example="Book deleted successfully"),
 *           ),
 *        ),
 *        @OA\Response(
 *            response=404,
 *            description="Not Found",
 *        ),
 *    ),
 *
 * @OA\Get(
 *         path="/api/books/author/{books}",
 *         summary="Автор книги",
 *         tags={"Books"},
 *
 *         @OA\Parameter(
 *             description="ID книги",
 *             in="path",
 *             name="Book",
 *             required=true,
 *             example=1
 *         ),
 *
 *         @OA\Response(
 *             response=200,
 *             description="OK",
 *             @OA\JsonContent(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some some name"),
 *                 @OA\Property(property="bio", type="string", example="Some some bio"),
 *                 @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                 @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                ),
 *         ),
 *         @OA\Response(
 *            response=404,
 *            description="Not Found",
 *         ),
 *     ),
 *
 * @OA\Get(
 *          path="/api/books/rentals/{book}",
 *          summary="Аренды книги",
 *          tags={"Books"},
 *
 *          @OA\Parameter(
 *              description="ID книги",
 *              in="path",
 *              name="Book",
 *              required=true,
 *              example=1
 *          ),
 *
 *          @OA\Response(
 *              response=200,
 *              description="OK",
 *              @OA\JsonContent( type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="user_id", type="integer", example=2),
 *                  @OA\Property(property="book_id", type="integer", example=1),
 *                  @OA\Property(property="rented_at", type="date", example="2024-11-21"),
 *                  @OA\Property(property="due_date", type="date", example="2024-12-06"),
 *                  @OA\Property(property="return_at", type="date", example=null),
 *                  @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                  @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                 )),
 *          ),
 *          @OA\Response(
 *             response=404,
 *             description="Not Found",
 *          ),
 *      ),
 *
 * @OA\Get(
 *           path="/api/books/users/{book}",
 *           summary="Пользователь книги",
 *           tags={"Books"},
 *
 *           @OA\Parameter(
 *               description="ID книги",
 *               in="path",
 *               name="Book",
 *               required=true,
 *               example=1
 *           ),
 *
 *           @OA\Response(
 *               response=200,
 *               description="OK",
 *               @OA\JsonContent( type="array", @OA\Items(
 *                   @OA\Property(property="id", type="integer", example=1),
 *                   @OA\Property(property="name", type="string", example="Enid Trantow"),
 *                   @OA\Property(property="email", type="string", example="pbernhard@example.com"),
 *                   @OA\Property(property="email_verified_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                   @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                   @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                  )),
 *           ),
 *           @OA\Response(
 *              response=404,
 *              description="Not Found",
 *           ),
 *       ),
 */
class BookController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BookResource::collection(Book::all());
    }

    public function show(Book $book): BookResource
    {
        return BookResource::make($book);
    }
    public function store(BookStoreRequest $request): BookResource
    {
        $validated = $request->validated();
        $author = Book::create($validated);
        return new BookResource($author);
    }

    public function update(BookUpdateRequest $request, Book $book): BookResource
    {
        $validated = $request->validated();
        $book->update($validated);
        return new BookResource($book);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();
        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }

    public function author(Book $book): JsonResponse
    {
        return response()->json($book->author);
    }

    public function rentals(Book $book): JsonResponse
    {
        return response()->json($book->rentals);
    }

    public function users(Book $book): JsonResponse
    {
        return response()->json($book->users);
    }
}
