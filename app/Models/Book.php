<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $guarded = false;

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'book_id');
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, Rental::class,'book_id','id','id','user_id');
    }
}
