<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Entertainment'],
            ['name' => 'Social'],
            ['name' => 'Music'],
            ['name' => 'Politics'],
            ['name' => 'Games'],
            ['name' => 'Sports'],
            ['name' => 'Relationships'],
            ['name' => 'Travels'],
            ['name' => 'Religion'],
        ]);
    }
}
