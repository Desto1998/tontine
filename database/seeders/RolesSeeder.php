<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = [
            'President',
            'Vice-President',
            'Administrator',
            'Secretary',
            'Sensor',
            'Treasurer',
            'Member',
            'Invited',
        ];
        // Insert roles
        foreach ($roles as $key => $role) {
            Role::create(['id' => $key + 1,'title' => $role]);
        }
    }
}
