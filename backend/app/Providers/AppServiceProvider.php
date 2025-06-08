<?php

namespace App\Providers;

use App\Models\book;
use App\Observers\BookObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Book::observe(BookObserver::class);
    }
}
