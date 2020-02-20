<?php

use Illuminate\Database\Seeder;
use App\Models\Place;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defalut_set = [
            [1, 'ChIJ3d5q2RCMGGAR4OXPZhEThrk', '台湾美食料理 留園 神保町店', 1]
        ];
        foreach ($defalut_set as $item) {
            $place = new Place();
            $place->place_id = $item[0];
            $place->google_place_id = $item[1];
            $place->place_name = $item[2];
            $place->place_type_id = $item[3];
            $place->status = 0;
            $place->save();
        }
    }
}
