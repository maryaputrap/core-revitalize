<?php

namespace Database\Seeders;

use App\Enums\OptionReference\OptionReferenceType;
use App\Models\OptionReference\OptionReference;
use Illuminate\Database\Seeder;

class OptionReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $endpoints = [
            [
                'code' => 'odf',
                'content' => 'ODF',
            ],
            [
                'code' => 'olt',
                'content' => 'OLT',
            ],
            [
                'code' => 'best_tray',
                'content' => 'BEST TRAY',
            ],
        ];

        $types = [
            OptionReferenceType::ENDPOINT() => $endpoints,
        ];

        foreach ($types as $type => $options) {
            foreach ($options as $option) {
                OptionReference::query()->create([
                    'type' => $type,
                    'code' => $option['code'],
                    'content' => $option['content'],
                ]);
            }
        }
    }
}
