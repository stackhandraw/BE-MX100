<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $company = User::factory()->create([
            'name' => 'PT MX100 Company',
            'email' => 'company@mx100.com',
            'role' => 'company',
            'password' => bcrypt('password'),
        ]);

        $freelancer = User::factory()->create([
            'name' => 'John Freelancer',
            'email' => 'freelancer@mx100.com',
            'role' => 'freelancer',
            'password' => bcrypt('password'),
        ]);

        \App\Models\JobPosting::factory(5)->create(['company_id' => $company->id]);
    }
}
