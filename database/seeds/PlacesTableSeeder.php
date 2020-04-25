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

        Place::create(['google_place_id'=>'ChIJSedYvoVwA2ARQBeC_aDPMbk', 'place_name'=>'ほうきぼし+ 神田店','formatted_address'=>'日本、〒101-0047 東京都千代田区内神田３丁目３−１９−９',
            'latitude'=>35.692261,'longitude'=>139.770738,'default_place_type_id'=>1,'default_header_img_url'=>'https://lh3.googleusercontent.com/p/AF1QipNL_2cRE52JFg1GC1kwqcd9nH2rLiAQLbNfGEPp=s1600-w500']);

        Place::create(['google_place_id'=>'ChIJb4lLAsOIGGARYnf96qa24fw', 'place_name'=>'らーめん潤 亀戸店','formatted_address'=>'日本、〒136-0071 東京都江東区亀戸６丁目２−１ SHIROUHOUSEⅡ 1F',
            'latitude'=>35.6941031,'longitude'=>139.8261436,'default_place_type_id'=>1,'default_header_img_url'=>'https://lh3.googleusercontent.com/p/AF1QipNxpXb2_bvmHjsV4fFBdKxUbtXA1AdEWnJ_wnLI=s1600-w500']);

        Place::create(['google_place_id'=>'ChIJ__9bxx2MGGARWfSFpLzW3pU', 'place_name'=>'麺屋はるか 秋葉原店','formatted_address'=>'日本、〒101-0021 東京都千代田区外神田３丁目１３−７ 田中無線電機ビルB1F',
            'latitude'=>35.7006858,'longitude'=>139.7711994,'default_place_type_id'=>1,'default_header_img_url'=>'https://lh3.googleusercontent.com/p/AF1QipNfYxrO4Cq0QLL6x311ZgR9r-7mtvWHMu-uOyWw=s1600-w500']);

        Place::create(['google_place_id'=>'ChIJTVq1bmnzGGAREa6fEwddJDA4', 'place_name'=>'鶏そば そると','formatted_address'=>'日本、〒155-0032 東京都世田谷区代沢５丁目３６−１３ 北村ビル 1F',
            'latitude'=>35.6592717,'longitude'=>139.6672374,'default_place_type_id'=>1,'default_header_img_url'=>'https://lh3.googleusercontent.com/p/AF1QipOsEF_I-w6Xz1JbGPSd7Mtcs99pZoPCTTuDWt96=s1600-w500']);

        Place::create(['google_place_id'=>'ChIJMSzCSn3yGGARL1Y7n1ij9tY', 'place_name'=>'混ぜそばみなみ','formatted_address'=>'日本、〒166-0003 東京都杉並区高円寺南４丁目７−５',
            'latitude'=>35.7032419,'longitude'=>139.6491212,'default_place_type_id'=>1,'default_header_img_url'=>'https://lh3.googleusercontent.com/p/AF1QipPAvNHaFuZYsEwJrNQptmYTv39XETrgvUecWHNQ=s1600-w500']);

        Place::create(['google_place_id'=>'ChIJSQ19PzH1GGAR3pE7ybBXZYI', 'place_name'=>'麺屋こころ 大岡山本店','formatted_address'=>'日本、〒145-0063 東京都大田区南千束３丁目６−９',
            'latitude'=>35.6038422,'longitude'=>139.6848881,'default_place_type_id'=>1,'default_header_img_url'=>'https://lh3.googleusercontent.com/p/AF1QipPAQM2DmVEpOxf8MgLsUNkMgrZSzwFg0Nn5Rfww=s1600-w500']);
    }
}
