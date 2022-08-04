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
