<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaceApiController extends Controller
{
    public function getPlaceDetail()
    {
        $place_id = $_POST['place_id'];
        $api_key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
        $url = "https://maps.googleapis.com/maps/api/place/details/json?key={$api_key}&place_id={$place_id}&language=ja";
        $json = file_get_contents($url);
        return $json;
    }
}

