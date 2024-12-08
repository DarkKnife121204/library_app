<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RentalStoreRequest;
use App\Http\Requests\RentalUpdateRequest;
use App\Http\Resources\RentalResource;
use App\Models\Rental;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
/**
 * @OA\Get(
 *       path="/api/rentals",
 *       summary="Список",
 *       tags={"Rentals"},
 *
 *       @OA\Response(
 *           response=200,
 *           description="OK",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(
 *                   @OA\Property(property="id", type="integer", example=1),
 *                   @OA\Property(property="user_id", type="integer", example=1),
 *                   @OA\Property(property="book_id", type="integer", example=1),
 *                   @OA\Property(property="rented_at", type="date", example="2024-11-24"),
 *                   @OA\Property(property="due_date", type="date", example="2024-11-30"),
 *                   @OA\Property(property="return_at", type="date", example="null"),
 *                   @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                   @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *               )),
 *           ),
 *       ),
 *   ),
 *
 * @OA\Post(
 *     path="/api/rentals",
 *     summary="Создание",
 *     tags={"Rentals"},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(ref="#/components/schemas/RentalStoreRequestSchema")
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=1),
 *                     @OA\Property(property="book_id", type="integer", example=1),
 *                     @OA\Property(property="rented_at", type="date", example="2024-11-24"),
 *                     @OA\Property(property="due_date", type="date", example="2024-11-30"),
 *                     @OA\Property(property="return_at", type="date", example="null"),
 *                     @OA\Property(property="created_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *                     @OA\Property(property="updated_at", type="date", example="2024-11-24T14:38:49.000000Z"),
 *             ),
 *         ),
 *     ),
 * ),
 *
 * @OA\Patch(
 *        path="/api/rentals/{rentals}",
 *        summary="Обновление",
 *        tags={"Rentals"},
 *
 *        @OA\Parameter(
 *            description="ID аренды",
 *            in="path",
 *            name="patсh",
 *            required=true,
 *            example=1
 *        ),
 *
 *        @OA\RequestBody(
 *            @OA\JsonContent(
 *                allOf={
 *                    @OA\Schema(ref="#/components/schemas/RentalUpdateRequestSchema")
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
 *                      @OA\Property(property="user_id", type="integer", example=1),
 *                      @OA\Property(property="book_id", type="integer", example=1),
 *                      @OA\Property(property="rented_at", type="date", example="2024-11-24"),
 *                      @OA\Property(property="due_date", type="date", example="2024-11-30"),
 *                      @OA\Property(property="return_at", type="date", example="null"),
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
 * @OA\Get(
 *         path="/api/rentals/books/{rental}",
 *         summary="Книга из аренды",
 *         tags={"Rentals"},
 *
 *         @OA\Parameter(
 *             description="ID аренды",
 *             in="path",
 *             name="author",
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
class RentalController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return RentalResource::collection(Rental::all());
    }
    public function store(RentalStoreRequest $request): RentalResource
    {
        $validated = $request->validated();
        $rental = Rental::create($validated);
        return new RentalResource($rental);
    }

    public function update(RentalUpdateRequest $request, Rental $rental): RentalResource
    {
        $validated = $request->validated();
        $rental->update($validated);
        return new RentalResource($rental);
    }

    public function book(Rental $rental): JsonResponse
    {
        return response()->json($rental->book);
    }
}
