<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeders::class);
        // $this->call(ProfileSeeders::class);
        $this->call(DesignationSeeder::class);
        $this->call(DepartmentSeeder::class);
        // $this->call(EmployeeSeeder::class);
    }
}
