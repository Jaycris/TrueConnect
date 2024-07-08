<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed the user
        $user = User::create([
            'email' => 'jayarcristobal@gmail.com',
            'username' => 'jaycris',
            'password' => Hash::make('password'), // Ensure password is hashed
            'user_type' => 'Admin',
        ]);

        // Seed the profile
        Profile::create([
            'user_id' => $user->id, // Reference the user_id
            'e_id' => '2024052351',
            'avatar' => null,
            'first_name' => 'Jay-ar',
            'middle_name' => null,
            'last_name' => 'Cristobal',
            'gender' => 'Male',
            'position' => 'Chief Executive Officer',
            'department' => 'Management'
        ]);
    }
}
