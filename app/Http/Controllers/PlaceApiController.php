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
    
    public function getHeaderImage()
    {
        $base_url = "https://maps.googleapis.com/maps/api/place/photo";
        $maxwidth = "500";
        $key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
        // $photoreference = "CmRaAAAArHCqh8wKJg94Bv_ksvzAhz1IW03ygjkY8UPOKdSwsRRCa_Gx4yLXVqMxuo7XyfNL4djtVFOL8Q-nze21zxQGvNlPfbct8Wm8x-k1XHBBnsw1QhTgBehNpYcQ26DjWEqHEhBPNkoyy9_wRyKnAM9iZaiOGhSUkCtenJ81LJXNoEcsrU-ZB8e98A";
        $photoreference = $_GET['photoreference'];
        $url = $base_url.'?'.'maxwidth='.$maxwidth.'&'.'key='.$key.'&'.'photoreference='.$photoreference;
        // $url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&photoreference=CmRaAAAArHCqh8wKJg94Bv_ksvzAhz1IW03ygjkY8UPOKdSwsRRCa_Gx4yLXVqMxuo7XyfNL4djtVFOL8Q-nze21zxQGvNlPfbct8Wm8x-k1XHBBnsw1QhTgBehNpYcQ26DjWEqHEhBPNkoyy9_wRyKnAM9iZaiOGhSUkCtenJ81LJXNoEcsrU-ZB8e98A";
        $header = get_headers($url);
        $img_url = preg_replace('@^Location: @', '', $header[5]);
        return $img_url;
    }
}
