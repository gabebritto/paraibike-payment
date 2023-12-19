<?php

namespace Database\Seeders;

use App\Models\Book;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 25; $i++)
        {
            Book::create([
                'name' => $faker->name,
                'publication_date' => $faker->date,
                'available_qty' => $faker->numberBetween(1, 200)
            ]);
        }
    }
}
