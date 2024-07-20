<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ports = [];

        for ($i = 1; $i <= 15; $i++) {
            $ports[] = [
                'name' => "PORT $i",
                'is_connected' => true,
                'max_core' => 1,
                'hardware_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        for ($i = 1; $i <= 24; $i++) {
            $ports[] = [
                'name' => "PORT $i",
                'is_connected' => true,
                'max_cores' => 1,
                'hardware_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('ports')->insert($ports);
    }
}
