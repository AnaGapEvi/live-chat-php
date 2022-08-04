<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            'name' => 'TeamA',
            'description' => 'team from A',
        ]);
        DB::table('rooms')->insert([
            'name' => 'TeamB',
            'description' => 'team from B',
        ]);
        DB::table('rooms')->insert([
        'name' => 'TeamC',
        'description' => 'team from C',
        ]);
    }
}
