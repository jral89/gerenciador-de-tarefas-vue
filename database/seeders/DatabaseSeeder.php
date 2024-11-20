<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test adm',
            'email' => 'adm@example.com',
            'password' => bcrypt('mudar@123'),
            'admin' => '1',
        ]);

        User::factory()->create([
            'name' => 'Test user',
            'email' => 'user@example.com',
            'password' => bcrypt('mudar@123'),
            'admin' => '0',
        ]);
    }
}
