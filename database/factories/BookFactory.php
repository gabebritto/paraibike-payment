<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'publication_date' => $this->faker->date(),
            'available_qty' => $this->faker->numberBetween(0, 1000),
            'created_at' => Carbon::now()->toDateString(),
            'updated_at' => Carbon::now()->toDateString(),
        ];
    }
}
