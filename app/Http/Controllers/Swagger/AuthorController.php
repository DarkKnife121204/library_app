<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
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
 *               @OA\Property(property="data", type="array", @OA\Items(
 *                   @OA\Property(property="id", type="integer", example=1),
 *                   @OA\Property(property="name", type="string", example="Some name"),
 *                   @OA\Property(property="bio", type="string", example="Some bio"),
 *                   @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                   @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *               )),
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
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="bio", type="string", example="Some bio"),
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                    @OA\Property(property="id", type="integer", example=1),
 *                    @OA\Property(property="name", type="string", example="Some name"),
 *                    @OA\Property(property="bio", type="string", example="Some bio"),
 *                    @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                    @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *             ),
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
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="bio", type="string", example="Some bio"),
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
 *                    @OA\Schema(
 *                        @OA\Property(property="name", type="string", example="Some some name"),
 *                        @OA\Property(property="bio", type="string", example="Some some bio"),
 *                    )
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
 *                      @OA\Property(property="name", type="string", example="Some some name"),
 *                      @OA\Property(property="bio", type="string", example="Some some bio"),
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
 *               @OA\Property(property="message", type="string", example="Worker deleted successfully"),
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

}
