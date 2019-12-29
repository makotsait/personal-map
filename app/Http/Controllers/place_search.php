<?php
function searchPlace($keyword) {
	$api_key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
	$place_id="ChIJ__9bxx2MGGARWfSFpLzW3pU";
	$keyword = urlencode($keyword);
	// $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?key={$api_key}&query={$keyword}";
	$url = "https://maps.googleapis.com/maps/api/place/details/json?key={$api_key}&place_id={$place_id}&language=ja";
	$json = file_get_contents($url);
	return json_decode($json, true);
}
// print_r(searchPlace("町屋駅"));
$array = searchPlace("町屋駅");
echo($array["result"]["formatted_address"]);
$opening_hours = $array["result"]["opening_hours"]["weekday_text"];
// var_dump($opening_hours);
foreach($opening_hours as $oh){
	echo($oh."\n");
}
echo('price_level: '.$array["result"]["price_level"]."\n");
echo('avrg_rating: '.$array["result"]["rating"]);
