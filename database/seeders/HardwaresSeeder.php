<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HardwaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hardwares')->insert([
            'code' => "OLT",
            'name' => "SBT-GUNUNG.KIJANG.7247-HW.MA5801-OLT-01",
            'port_total' => 15,
            'container_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('hardwares')->insert([
            'code' => "ODF",
            'name' => "ODF-02",
            'port_total' => 24,
            'container_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
