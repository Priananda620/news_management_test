<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create User with role_id = 1
        User::create([
            'username' => 'user_with_role_1',
            'email' => 'prianandaazhar@yopmail.com',
            'user_role_id' => 1,
            'password' => Hash::make('password123')
        ]);

        // Create User with role_id = 2
        User::create([
            'username' => 'user_with_role_2',
            'email' => 'user1@yopmail.com',
            'user_role_id' => 2,
            'password' => Hash::make('password123')
        ]);
    }

}
