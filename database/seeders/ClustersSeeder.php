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
        $totalRows = 1;

        if (($open = fopen(database_path("seeders/data/clusters.csv"), "r")) !== false) {
            fgetcsv($open);

            $this->command->withProgressBar($totalRows, function ($bar) use ($open) {
                $bar->setFormat("   %percent:3s%% [%bar%] %current%/%max% in %elapsed:6s%");

                while (($row = fgetcsv($open, separator: ",")) !== false) {
                    $newCluster = [
                        'name' => "{$row[0]}",
                        'address' => "{$row[1]}",
                        'latitude' => "{$row[2]}",
                        'longitude' => "{$row[3]}",
                    ];

                    Cluster::query()->insert($newCluster);

                    $bar->advance();
                }
            });


            fclose($open);
        }
    }
}
