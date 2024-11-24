<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RentalStoreRequest;
use App\Http\Requests\RentalUpdateRequest;
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
