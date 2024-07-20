<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_levels')->insert([
            'name' => 'Super Admin'
        ]);

        DB::table('user_levels')->insert([
            'name' => 'Admin'
        ]);

        DB::table('user_levels')->insert([
            'name' => 'Worker'
        ]);
    }
}
