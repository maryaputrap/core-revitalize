<?php

namespace Database\Seeders;

use App\Models\Container;
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
        if (($open = fopen(database_path("seeders/data/containers.csv"), "r")) !== false) {
            fgetcsv($open);

            while (($row = fgetcsv($open)) !== false) {
                $newContainer = [
                    'cluster_id' => "$row[0]",
                    'name' => "$row[1]",
                    'latitude' => "$row[2]",
                    'longitude' => "$row[3]",
                ];

                Container::query()->insert($newContainer);
            }

            fclose($open);
        }
    }
}
