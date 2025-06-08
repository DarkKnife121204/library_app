<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationReserveRequest;
use App\Http\Requests\ReservationUpdateStatusRequest;
use App\Http\Resources\ReservationResource;
use App\Models\book;
use App\Models\reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ReservationResource::collection(
            Reservation::with(['user', 'book'])->get()
        );
    }

    public function show(Reservation $reservation): ReservationResource
    {
        return ReservationResource::make($reservation);
    }

    public function reserve(ReservationReserveRequest $request): JsonResponse
    {
        $user = auth()->user();
        $bookId = $request->validated();

        $book = Book::where('id', $bookId)->firstOrFail();

        if (!$book->is_available) {
            return response()->json(['error' => 'Книга уже забронирована'], 409);
        }

        $reservation = Reservation::create([
            'user_id'     => $user->id,
            'book_id'     => $book->id,
            'reserved_at' => now(),
            'expires_at'  => now()->copy()->addDays(2),
        ]);

        $book->update(['is_available' => false]);

        return response()->json([
            'message' => 'Книга успешно забронирована',
            'data' => new ReservationResource($reservation)
        ], 201);
    }

    public function updateStatus(ReservationUpdateStatusRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $newStatus = $validated['status'];

        $reservation = Reservation::with('book')->findOrFail($id);
        $user = auth()->user();

        if (in_array($reservation->status, ['returned', 'cancelled'])) {
            return response()->json(['error' => 'Бронь уже завершена и не может быть изменена'], 400);
        }

        $role = $user->role;

        $rolePermissions = [
            'user' => ['cancelled'],
            'librarian' => ['issued', 'returned', 'cancelled'],
        ];

        if (!in_array($newStatus, $rolePermissions[$role] ?? [])) {
            return response()->json(['error' => 'Недостаточно прав для установки этого статуса'], 403);
        }


        match ($newStatus) {
            'issued'   => $reservation->issued_at = now(),
            'returned' => $reservation->returned_at = now(),
            default    => null,

        };

        if (in_array($newStatus, ['returned', 'cancelled'])) {
            $reservation->book->update(['is_available' => true]);
        }

        $reservation->status = $newStatus;
        $reservation->save();

        return response()->json([
            'message' => 'Статус обновлён',
            'data'    => $reservation,
        ], 200);
    }
}
