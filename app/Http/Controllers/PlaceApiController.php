<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaceApiController extends Controller
{
    public function fetchPlaceDetails($place_id)
    {
        $api_key = config('app.google_place_api_php');
        $url = "https://maps.googleapis.com/maps/api/place/details/json?key={$api_key}&place_id={$place_id}&language=ja";
        $json = file_get_contents($url);
        return json_decode($json, true);
    }
    
    public function fetchHeaderImgUrl($photoreference)
    {
        $api_key = config('app.google_place_api_php');
        $maxwidth = "500";
        $url = "https://maps.googleapis.com/maps/api/place/photo?key={$api_key}&photoreference={$photoreference}&maxwidth={$maxwidth}";
        $header = get_headers($url);
        $img_url = preg_replace('@^Location: @', '', $header[5]);
        return $img_url;
    }
}
