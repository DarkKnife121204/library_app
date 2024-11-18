<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';
    protected $fillable = [
        'user_id',
        'book_id',
        'rented_at',
        'due_date',
        'return_at',
    ];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
