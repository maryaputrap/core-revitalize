<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TubesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tubes')->insert([
            'color' => "BIRU",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tubes')->insert([
            'color' => "ORANGE",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tubes')->insert([
            'color' => "HIJAU",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tubes')->insert([
            'color' => "COKLAT",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tubes')->insert([
            'color' => "ABU",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tubes')->insert([
            'color' => "PUTIH",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tubes')->insert([
            'color' => "MERAH",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tubes')->insert([
            'color' => "HITAM",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
