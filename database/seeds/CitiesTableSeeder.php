<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            ['name' => 'Paris','country_id' => 1],
            ['name' => 'Lyon','country_id' => 1],
            ['name' => 'Marseilles','country_id' => 1],
            ['name' => 'Berlin','country_id' => 2],
            ['name' => 'Munich','country_id' => 2],
            ['name' => 'Vienna','country_id' => 1],
        ]);
    }
}
