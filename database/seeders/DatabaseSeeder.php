<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            PermissionSeeder::class,
            RolesSeeder::class,
        ]);
        \App\Models\User::factory()->create([
            'first_name' => 'Desto',
            'last_name' => '237',
            'email' => 'desto237@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '676934987',
            'last_seen' => now(),
            'is_admin' => 1,
        ]);
    }
}
