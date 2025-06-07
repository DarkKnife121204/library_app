<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class book extends Model
{
    protected $table = 'books';
    protected $fillable = [
        'title',
        'author',
        'is_available',
        'genre',
        'publisher'
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
