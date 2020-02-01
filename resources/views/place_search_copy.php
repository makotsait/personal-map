<?php
function searchPlace($keyword, $place_id) {
	$place_id = "ChIJ35JJigfzGGAREQEXjF2_n8A";
	$api_key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
	$keyword = urlencode($keyword);
	$url = "https://maps.googleapis.com/maps/api/place/details/json?key=".$api_key."&place_id=".$place_id."&language=ja";
	$json = file_get_contents($url);
	return json_decode($json, true);
}
$array = searchPlace("東京駅", $place_id);
// var_dump($array);
echo 'test';
// echo($array["result"]["formatted_address"]);
// $opening_hours = $array["result"]["opening_hours"]["weekday_text"];
// // var_dump($opening_hours);
// foreach($opening_hours as $oh){
// 	echo($oh."\n");
// }
// echo('price_level: '.$array["result"]["price_level"]."\n");
// echo('avrg_rating: '.$array["result"]["rating"]);
