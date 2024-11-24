<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author_id' => Author::inRandomOrder()->first()->id,
            'published_at' => fake()->date,
        ];
    }
}
