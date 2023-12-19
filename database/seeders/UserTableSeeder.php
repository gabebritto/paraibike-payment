<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        $this->createUser(
            'Testing',
            'test@user.com',
            'testing'
        );
    }

    private function createUser($name, $email, $password)
    {
        if (!User::where('email', $email)->exists())
        {
            User::create(['name' => $name, 'email' => $email, 'password' => bcrypt($password)]);
        }
    }
}
