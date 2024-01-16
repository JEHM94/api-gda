<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommunesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Provee algunos datos de ejemplo para la tabla de Comunas
        $datos = [
            array(
                'region_id' =>  1,
                'description' =>  "Alto Orinoco (La Esmeralda)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  1,
                'description' =>  "Atures (Puerto Ayacucho)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  1,
                'description' =>  "Maroa (Maroa)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  2,
                'description' =>  "Bejuma (Bejuma)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  2,
                'description' =>  "Libertador (Tocuyito)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  2,
                'description' =>  "Valencia (Valencia)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  3,
                'description' =>  "Antonio Díaz (Curiapo)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  3,
                'description' =>  "Casacoima (Sierra Imataca)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  3,
                'description' =>  "Pedernales (Pedernales)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  4,
                'description' =>  "Crespo (Duaca)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  4,
                'description' =>  "Iribarren (Barquisimeto)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'region_id' =>  4,
                'description' =>  "Jiménez (Quibor)",
                'status' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ];

        DB::table('communes')->insert($datos);
    }
}
