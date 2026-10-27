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
            'label' => 'Nouveau',
        ]);

        DB::table('statuses')->insert([
            'id' => 2,
            'code' => 5,
            'label' => 'Validé', // Attribué
        ]);

        DB::table('statuses')->insert([
            'id' => 3,
            'code' => 10,
            'label' => 'En cours',
        ]);

        DB::table('statuses')->insert([
            'id' => 4,
            'code' => 15,
            'label' => 'En Attente',
        ]);

        DB::table('statuses')->insert([
            'id' => 5,
            'code' => 20,
            'label' => 'Cotiser',
        ]);

        DB::table('statuses')->insert([
            'id' => 6,
            'code' => 25,
            'label' => 'Payé',
        ]);

        DB::table('statuses')->insert([
            'id' => 7,
            'code' => 30,
            'label' => 'Décaissé',
        ]);

        DB::table('statuses')->insert([
            'id' => 8,
            'code' => 35,
            'label' => 'Remboursé',
        ]);

        DB::table('statuses')->insert([
            'id' => 9,
            'code' => 40,
            'label' => 'Encaissé',
        ]);

        DB::table('statuses')->insert([
            'id' => 10,
            'code' => 45,
            'label' => 'Encaissé',
        ]);

        DB::table('statuses')->insert([
            'id' => 11,
            'code' => 50,
            'label' => 'Terminé',
        ]);

        DB::table('statuses')->insert([
            'id' => 12,
            'code' => 55,
            'label' => 'Reconfirmé',
        ]);

        DB::table('statuses')->insert([
            'id' => 13,
            'code' => 60,
            'label' => 'Reporté',
        ]);
        DB::table('statuses')->insert([
            'id' => 14,
            'code' => 65,
            'label' => 'Gelé',
        ]);

        DB::table('statuses')->insert([
            'id' => 15,
            'code' => 70,
            'label' => 'Annulé',
        ]);

        DB::table('statuses')->insert([
            'id' => 16,
            'code' => 75,
            'label' => 'Inactif',
        ]);

        DB::table('statuses')->insert([
            'id' => 17,
            'code' => 80,
            'label' => 'Echoué',
        ]);

        DB::table('statuses')->insert([
            'id' => 18,
            'code' => 85,
            'label' => 'Refusé',
        ]);


    }
}
