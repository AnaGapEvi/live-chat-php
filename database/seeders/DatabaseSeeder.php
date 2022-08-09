<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('rooms')->insert([
            'name' => 'Room 1',
            'description' => 'Room 1',
        ]);
        DB::table('rooms')->insert([
            'name' => 'Room 2',
            'description' => 'Room 2',
        ]);
        DB::table('rooms')->insert([
            'name' => 'Room 3',
            'description' => 'Room  3',
        ]);
    }
}
