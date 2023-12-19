<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Runs the referenced seeders
     */
    public function run(): void
    {
        $this->call([
            BooksTableSeeder::class,
            UserTableSeeder::class
        ]);
    }
}
