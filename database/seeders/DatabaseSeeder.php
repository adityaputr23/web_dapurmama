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

        // Seed admin user
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@dapurbunda.com'],
            [
                'name' => 'Bunda Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('Admin@2025'),
                'role' => 'admin',
            ]
        );

        // Remove old admin if exists
        \App\Models\User::where('email', 'admin@dapurmama.com')
            ->where('role', 'admin')
            ->delete();

        // Seed a customer user
        \App\Models\User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Ibu Lestari',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'customer',
            ]
        );

        $this->call([
            MenuSeeder::class,
        ]);
    }
}
