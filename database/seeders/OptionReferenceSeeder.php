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
            [
                'code' => 'fat',
                'content' => 'FAT',
            ],
            [
                'code' => 'jb',
                'content' => 'JB',
            ],
        ];

        $types = [
            OptionReferenceType::ENDPOINT() => $endpoints,
        ];

        foreach ($types as $type => $options) {
            foreach ($options as $option) {
                if (OptionReference::query()->where('type', $type)->where('code', $option['code'])->exists()) {
                    continue;
                }

                OptionReference::query()->create([
                    'type' => $type,
                    'code' => $option['code'],
                    'content' => $option['content'],
                ]);
            }
        }
    }
}
