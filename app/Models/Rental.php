<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';
    protected $guarded = false;
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
