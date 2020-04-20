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
        Place::create(['google_place_id'=>'ChIJ3d5q2RCMGGAR4OXPZhEThrk', 'place_name'=>'台湾美食料理 留園 神保町店','formatted_address'=>'日本、〒101-0052 東京都千代田区神田小川町３丁目３−１６ 小林ビル 2F',
            'latitude'=>35.6966869,'longitude'=>139.7603095,'default_place_type_id'=>1,'default_header_img_url'=>'https://lh3.googleusercontent.com/p/AF1QipPix4wgdanzfLk2uCzQ6P0KM-wsnU1VkSGrrr5e=s1600-w500']);
        Place::create(['google_place_id'=>'ChIJi6UGCKV3A2ARUo77w9rQKy4', 'place_name'=>'麺屋はなび 高畑本店','formatted_address'=>'日本、〒454-0911 愛知県名古屋市中川区高畑１丁目１７０',
            'latitude'=>35.1411749,'longitude'=>136.8567543,'default_place_type_id'=>1,'default_header_img_url'=>'https://lh3.googleusercontent.com/p/AF1QipPJXu-ocJEuZoskFhmq8Cwj0meD2R4toKnFva5c=s1600-w500']);
    }
}
