<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class reservation extends Model
{
    protected $table = 'reservations';
    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'reserved_at',
        'expires_at',
        'issued_at',
        'returned_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
