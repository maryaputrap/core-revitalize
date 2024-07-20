<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ContainersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('containers')->insert([
            'code' => "POP",
            'name' => "POP_1BSB10019_Bintan_Gunung Kijang 7247",
            'latitude' => 1.1864000,
            'longitude' => 104.5767020,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('containers')->insert([
            'code' => "FDT",
            'name' => "FDT_BSBF10009",
            'latitude' => 1.1864010,
            'longitude' => 104.5766940,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
