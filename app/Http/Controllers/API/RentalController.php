<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rental\StoreRequest;
use App\Http\Requests\Rental\UpdateRequest;
use App\Http\Resources\RentalResource;
use App\Models\Rental;

class RentalController extends Controller
{
    public function index()
    {
        return RentalResource::collection(Rental::all());
    }
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $rental = Rental::create($validated);
        return new RentalResource($rental);
    }

    public function update(UpdateRequest $request, Rental $rental)
    {
        $validated = $request->validated();
        $rental->update($validated);
        return new RentalResource($rental);
    }

    public function book(Rental $rental)
    {
        return response()->json($rental->book);
    }
}
