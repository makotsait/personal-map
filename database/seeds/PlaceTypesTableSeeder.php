<?php

use Illuminate\Database\Seeder;
use App\Models\PlaceType;

class PlaceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defalut_set = [
            [1, 'restaurant', 'レストラン'], [2, 'cafe', 'カフェ'], [3, 'hospital', '病院'], [4, 'lodging', 'ホテル'],
            [5, 'tourist_attraction', '観光施設'], [6, 'park', '公園'], [7, 'amusement_park', '遊園地']
        ];
        foreach ($defalut_set as $item) {
            $place_type = new PlaceType();
            $place_type->criterion_id = $item[0];
            $place_type->criterion_name_en = $item[1];
            $place_type->criterion_name_ja = $item[2];
            $place_type->status = 0;
            $place_type->save();
        }
    }
}