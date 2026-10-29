<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert order status against
        DB::table('statuses')->insert([
            'id' => 1,
            'code' => 0,
            'title' => 'Nouveau',
        ]);

        DB::table('statuses')->insert([
            'id' => 2,
            'code' => 5,
            'title' => 'En Attente',
        ]);

        DB::table('statuses')->insert([
            'id' => 3,
            'code' => 10,
            'title' => 'Validé', // Attribué
        ]);

        DB::table('statuses')->insert([
            'id' => 4,
            'code' => 15,
            'title' => 'En cours',
        ]);


        DB::table('statuses')->insert([
            'id' => 5,
            'code' => 20,
            'title' => 'Cotiser',
        ]);

        DB::table('statuses')->insert([
            'id' => 6,
            'code' => 25,
            'title' => 'Payé',
        ]);

        DB::table('statuses')->insert([
            'id' => 7,
            'code' => 30,
            'title' => 'Décaissé',
        ]);

        DB::table('statuses')->insert([
            'id' => 8,
            'code' => 35,
            'title' => 'Remboursé',
        ]);

        DB::table('statuses')->insert([
            'id' => 9,
            'code' => 40,
            'title' => 'Encaissé',
        ]);

        DB::table('statuses')->insert([
            'id' => 10,
            'code' => 45,
            'title' => 'Encaissé',
        ]);

        DB::table('statuses')->insert([
            'id' => 11,
            'code' => 50,
            'title' => 'Terminé',
        ]);

        DB::table('statuses')->insert([
            'id' => 12,
            'code' => 55,
            'title' => 'Reconfirmé',
        ]);

        DB::table('statuses')->insert([
            'id' => 13,
            'code' => 60,
            'title' => 'Reporté',
        ]);
        DB::table('statuses')->insert([
            'id' => 14,
            'code' => 65,
            'title' => 'Gelé',
        ]);

        DB::table('statuses')->insert([
            'id' => 15,
            'code' => 70,
            'title' => 'Annulé',
        ]);

        DB::table('statuses')->insert([
            'id' => 16,
            'code' => 75,
            'title' => 'Inactif',
        ]);

        DB::table('statuses')->insert([
            'id' => 17,
            'code' => 80,
            'title' => 'Echoué',
        ]);

        DB::table('statuses')->insert([
            'id' => 18,
            'code' => 85,
            'title' => 'Refusé',
        ]);


    }
}
