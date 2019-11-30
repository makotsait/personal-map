<?php
function searchPlace($keyword) {
	$api_key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
	$keyword = urlencode($keyword);
	$url = "https://maps.googleapis.com/maps/api/place/textsearch/json?key={$api_key}&query={$keyword}";
	$json = file_get_contents($url);
	return json_decode($json, true);
}
print_r(searchPlace("町屋駅"));