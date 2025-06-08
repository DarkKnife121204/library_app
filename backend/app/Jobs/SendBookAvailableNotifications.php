<?php

namespace App\Jobs;

use App\Mail\BookAvailableMail;
use App\Models\book;
use App\Models\NotificationRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBookAvailableNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Book $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function handle()
    {
        $requests = NotificationRequest::where('book_id', $this->book->id)
            ->whereNull('notified_at')
            ->with('user')
            ->get();

        foreach ($requests as $request) {
            Mail::to($request->user->email)->send(new BookAvailableMail($this->book));
            $request->update(['notified_at' => now()]);
        }
    }
}
