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
        $validate = $request->validated();
        $rental = Rental::create($validate);
        return new RentalResource($rental);
    }

    public function update(UpdateRequest $request, Rental $rental)
    {
        $validate = $request->validated();
        $rental->update($validate);
        $rental->fresh();
        return new RentalResource($rental);
    }

    public function book(Rental $rental)
    {
        return response()->json($rental->book);
    }
}
