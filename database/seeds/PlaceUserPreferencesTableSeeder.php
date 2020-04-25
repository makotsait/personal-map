<?php

use Illuminate\Database\Seeder;
use App\Models\PlaceUserPreference;

class PlaceUserPreferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlaceUserPreference::create(['user_id'=>1, 'place_id'=>1,'place_type_id'=>1]);
        PlaceUserPreference::create(['user_id'=>2, 'place_id'=>2,'place_type_id'=>1]);
        PlaceUserPreference::create(['user_id'=>2, 'place_id'=>3,'place_type_id'=>1]);
        PlaceUserPreference::create(['user_id'=>2, 'place_id'=>4,'place_type_id'=>1]);
        PlaceUserPreference::create(['user_id'=>2, 'place_id'=>5,'place_type_id'=>1]);
        PlaceUserPreference::create(['user_id'=>2, 'place_id'=>6,'place_type_id'=>1]);
        PlaceUserPreference::create(['user_id'=>2, 'place_id'=>7,'place_type_id'=>1]);
        PlaceUserPreference::create(['user_id'=>2, 'place_id'=>8,'place_type_id'=>1]);
    }
}
