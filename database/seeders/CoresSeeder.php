<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cores = [];

        for ($i = 1; $i <= 15; $i++) {
            $cores[] = [
                'color' => "MERAH",
                'port_from_id' => $i,
                'port_to_id' => $i + 15,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cores')->insert($cores);
    }
}
