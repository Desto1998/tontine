<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Delete all permission in DB first
//        Permission::truncate();
        $permissions = [
            'list',
            'edit',
            'delete',
            'user-list',
            'user-edit',
            'user-delete',
        ];
        // Insert roles
        foreach ($permissions as $key => $title) {
            Permission::create(['id' => $key + 1,'title' => $title]);
        }
    }
}
