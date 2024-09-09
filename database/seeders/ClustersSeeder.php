<?php

namespace Database\Seeders;

use App\Models\Cluster;
use Illuminate\Database\Seeder;

class ClustersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (($open = fopen(database_path("seeders/data/clusters.csv"), "r")) !== false) {
            fgetcsv($open);

            while (($row = fgetcsv($open)) !== false) {
                $newCluster = [
                    'name' => "$row[0]",
                    'address' => "$row[1]",
                    'latitude' => "$row[2]",
                    'longitude' => "$row[3]",
                ];

                Cluster::query()->insert($newCluster);

            }

            fclose($open);
        }
    }
}
