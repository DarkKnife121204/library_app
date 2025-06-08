<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequestRequest;
use App\Models\NotificationRequest;
use Illuminate\Http\JsonResponse;

class NotificationRequestController extends Controller
{
    public function store(NotificationRequestRequest $request): JsonResponse
    {
        $validated = $request->validated();

        NotificationRequest::create([
            'user_id' => auth()->id(),
            'book_id' => $validated['book_id'],
        ]);

        return response()->json(['message' => 'Вы будете уведомлены, когда книга станет доступна.'], 200);
    }
    public function destroy(NotificationRequestRequest $request): JsonResponse
    {
        $validated = $request->validated();

        NotificationRequest::where('user_id', auth()->id())
            ->where('book_id', $validated['book_id'])
            ->delete();

        return response()->json(['message' => 'Уведомление отменено.']);
    }
}
