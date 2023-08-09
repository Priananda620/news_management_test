<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        UserRole::create(['role' => 'ADMIN']);
        UserRole::create(['role' => 'BASIC_USER']);
    }

}
