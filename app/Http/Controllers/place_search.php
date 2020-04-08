<?php
function searchPlace($place_id)
{
	$api_key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
	$place_id = $place_id;
	// $keyword = urlencode($keyword);
	// $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?key={$api_key}&query={$keyword}";
	$url = "https://maps.googleapis.com/maps/api/place/details/json?key={$api_key}&place_id={$place_id}&language=ja";
	$json = file_get_contents($url);
	return json_decode($json, true);
}
// print_r(searchPlace("東京駅"));
// place detailのjson取得
// $url = "https://maps.googleapis.com/maps/api/place/details/json?key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&place_id=ChIJH7qx1tCMGGAR1f2s7PGhMhw&language=ja";
// place head imgの取得

// $url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&photoreference=CmRaAAAArHCqh8wKJg94Bv_ksvzAhz1IW03ygjkY8UPOKdSwsRRCa_Gx4yLXVqMxuo7XyfNL4djtVFOL8Q-nze21zxQGvNlPfbct8Wm8x-k1XHBBnsw1QhTgBehNpYcQ26DjWEqHEhBPNkoyy9_wRyKnAM9iZaiOGhSUkCtenJ81LJXNoEcsrU-ZB8e98A";
// $header=get_headers($url);
// print_r($header);
// $img_url = preg_replace('@^Location: @','',$header[5]);
// echo $img_url;
echo 'Google_place_id:';
$stdin = trim(fgets(STDIN));
$array = searchPlace($stdin);
// var_dump($array);
echo $array["result"]["geometry"]["location"]["lat"];
echo $array["result"]["geometry"]["location"]["lng"];
// echo($array["result"]["photos"][0]["photo_reference"]);
// $opening_hours = $array["result"]["opening_hours"]["weekday_text"];
// // var_dump($opening_hours);
// foreach($opening_hours as $oh){
// 	echo($oh."\n");
// }
// echo('price_level: '.$array["result"]["price_level"]."\n");
// echo('avrg_rating: '.$array["result"]["rating"]);
