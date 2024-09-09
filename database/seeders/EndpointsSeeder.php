<?php

namespace Database\Seeders;

use App\Models\Endpoint;
use App\Services\EndpointService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EndpointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (($open = fopen(database_path("seeders/data/endpoints.csv"), "r")) !== false) {
            fgetcsv($open);

            while (($row = fgetcsv($open)) !== false) {
                $newEndpoint = [
                    'type_id' => "$row[0]",
                    'cluster_id' => "$row[1]",
                    'container_id' => "$row[2]",
                    'name' => "$row[3]",
                    'port_total' => "$row[4]",
                ];

                $sv = new EndpointService();
            }

            fclose($open);
        }
    }
}
