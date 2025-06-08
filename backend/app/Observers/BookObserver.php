<?php

namespace App\Observers;

use App\Jobs\SendBookAvailableNotifications;
use App\Models\Book;
use App\Models\NotificationRequest;

class BookObserver
{
    public function updated(Book $book): void
    {

        if ($book->isDirty('is_available') && $book->is_available) {
            SendBookAvailableNotifications::dispatch($book);
        }
    }
}
