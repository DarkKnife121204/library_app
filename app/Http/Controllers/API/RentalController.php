<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rental\StoreRequest;
use App\Http\Requests\Rental\UpdateRequest;
use App\Http\Resources\RentalResource;
use App\Models\Rental;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RentalController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return RentalResource::collection(Rental::all());
    }
    public function store(StoreRequest $request): RentalResource
    {
        $validated = $request->validated();
        $rental = Rental::create($validated);
        return new RentalResource($rental);
    }

    public function update(UpdateRequest $request, Rental $rental): RentalResource
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
