<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Rafael',
            'email' => 'rafael@gmail.com',
            'password' => Hash::make(env('USER_PASS', 'admin')),
        ]);

        User::create([
            'name' => 'John',
            'email' => 'john@gmail.com',
            'password' => Hash::make(env('USER_PASS', 'admin')),
        ]);
    }
}
