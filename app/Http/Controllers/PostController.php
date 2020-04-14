<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

use Illuminate\Http\Request;

use App\Models\Rating;
use App\Models\Place;
use App\Models\Criterion;
use App\Models\CriteriaOrder;
use App\Models\Note;
use App\Models\PlaceType;
use App\Models\PlaceUserPreference;

class PostController extends Controller
{
    public $default_criteria_order = array(
        // [0]:criterion_id, [1]:display_order
        '1' => array([1, 1], [2, 2], [6, 3], [4, 4]),
        '2' => array([3, 1], [2, 2], [1, 3], [4, 4]),
        '3' => array([7, 1], [8, 2], [5, 3], [6, 4]),
        '4' => array([3, 1], [2, 2], [5, 3], [6, 4]),
        '5' => array([10, 1], [2, 2], [9, 3], [4, 4]),
        '6' => array([3, 1], [5, 2], [9, 3], [4, 4]),
        '7' => array([10, 1], [2, 2], [9, 3], [4, 4]),
        '8' => array([11, 1], [12, 2], [5, 3], [3, 4])
    );
    public function index(Request $request)
    {
        // $items = PostRatings::();
        // return view('', ['items' => $items]);
    }
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setCriteriaOrderDefaultValue($user_id, $place_type_id)
    {
        foreach ($this->default_criteria_order[$place_type_id] as $item) {
            $criteria_order = new CriteriaOrder();
            $criteria_order->user_id = $user_id;
            $criteria_order->place_type_id = $place_type_id;
            $criteria_order->criterion_id = $item[0];
            $criteria_order->display_order = $item[1];
            $criteria_order->status = 0;
            $criteria_order->save();
        }
    }

    public function fetchPlaceDetails()
    {
        $google_place_id = $_GET['google_place_id'];

        $place_details = array();
        $place_details['google_place_id'] = $google_place_id;

        $place = Place::where('google_place_id', $google_place_id)->where('status', 0)->first();
        if (isset($place)) {
            $place_details['place_name'] = $place->place_name;
            $place_details['formatted_address'] = $place->formatted_address;
            $place_details["location"]["lat"] = $place->latitude;
            $place_details["location"]["lng"] = $place->longitude;
            $place_details['header_img_url'] = $place->default_header_img_url;
        } else {
            $place_api_controller = app()->make('App\Http\Controllers\PlaceApiController');
            $api_data = $place_api_controller->fetchPlaceDetails($google_place_id);

            $place_details['place_name'] = $api_data["result"]["name"];
            $place_details['formatted_address'] = $api_data["result"]["formatted_address"];
            $place_details["location"]["lat"] = $api_data["result"]["geometry"]["location"]["lat"];
            $place_details["location"]["lng"] = $api_data["result"]["geometry"]["location"]["lng"];
            $place_details['header_img_url'] = $place_api_controller->fetchHeaderImgUrl($api_data["result"]["photos"][0]["photo_reference"]);
        }
        
        return $place_details;
    }

    public function getPlaceTypeOpions()
    {
        $items = array();
        $place_types = PlaceType::all();
        $i = 0;
        foreach ($place_types as $place_type) {
            $items['place_type_id'][$i] = $place_type->place_type_id;
            $items['place_type_name_ja'][$i] = $place_type->place_type_name_ja;
            $i++;
        }
        return json_encode($items);
    }

    public function getRatings()
    {
        $google_place_id = $_GET['google_place_id'];
        $user_id = Auth::user()->user_id;
        $items = array();

        $criterion_exists = Criterion::where('status', 0)->exists();
        if (!$criterion_exists) {
            return 'criterion not found in db';
        }
        $criteria = Criterion::where('status', 0)->get();
        $criterion_name_ls = array();
        foreach ($criteria as $criterion) {
            $criterion_name_ls[$criterion->criterion_id] = $criterion->criterion_name_ja;
        }

        // $i = 0;
        foreach ($this->default_criteria_order as $place_type_id => $criteria_order) {
            foreach ($criteria_order as $k => $order) {
                $sort[$k] = $order[1];
            }
            array_multisort($sort, SORT_ASC, $criteria_order);

            foreach ($criteria_order as $k =>  $order) {
                $items['default_order'][$place_type_id]['criterion_id'][$k] = $order[0];
                $items['default_order'][$place_type_id]['criterion_name_ja'][$k] = $criterion_name_ls[$order[0]];
                $items['default_order'][$place_type_id]['ratings'][$k] = 0;
            }
            // $i++;
        }
        $place = Place::where('google_place_id', $google_place_id)->where('status', 0)->first();
        if (is_null($place)) {
            $items['user_order'][0] = '';
            $items['note'] = '';
            return $items;
        }

        $place_id = $place->place_id;

        // editing
        $place_user_pref = PlaceUserPreference::where('google_place_id', $google_place_id)->where('user_id', $user_id)->where('status', 0)->first();
        if (isset($place_user_pref)) {
            $items['place_type_id'] = $place_user_pref->place_type_id;
        } elseif (is_null($place_user_pref)) {
            $items['place_type_id'] = $place->default_place_type_id;
        }

        $criteria_order_exists = CriteriaOrder::where('user_id', $user_id)->where('status', 0)->exists();
        if (!$criteria_order_exists) {
            return 'criteria_order not found in db';
        }
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('status', 0)->orderBy('display_order', 'asc')->orderBy('place_type_id', 'asc')->get();

        // $i = 0;
        foreach ($criteria_order as $order) {
            // $i++;
            $items['user_order'][$order->place_type_id]['criterion_id'][] = $order->criterion_id;
            $items['user_order'][$order->place_type_id]['criterion_name_ja'][] = $order->criterion->criterion_name_ja;
            $rating = Rating::where('user_id', $user_id)->where('place_id', $place_id)->where('criterion_id', $order->criterion_id)->first();
            if (is_null($rating)) {
                $rating_value = 0;
            } else {
                $rating_value = $rating->rating;
            };
            $items['user_order'][$order->place_type_id]['ratings'][] = $rating_value;
        }

        $note = Note::where('user_id', $user_id)->where('place_id', $place_id)->first();
        if (is_null($note)) {
            $items['note'] = '';
        } else {
            $items['note'] = $note->note;
        };

        return json_encode($items);
    }

    public function updateRatings(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->user_id;
        $google_place_id = $request->google_place_id;
        $place_type_id = $request->form_place_type_id;
        $place = Place::where('google_place_id', $google_place_id)->first();
        if (is_null($place)) {
            // 施設の追加
            $place = new Place();
            $place->google_place_id = $google_place_id;
            $place->place_name = $request->form_place_name;
            $place->formatted_address = $request->form_formatted_address;
            $place->latitude = $request->form_latitude;
            $place->longitude = $request->form_longitude;
            // [todo]place_apiから取得したjsonにplace_typeが複数入力されているのでマッチするものがあればデフォルト値として入れる機能の実装
            $place->default_place_type_id = 1;
            $place->default_header_img_url = $request->form_header_img_url;
            $place->status = 0;
            $place->save();
            // ↓一行は必要なのか？（[todo]削除して動作確認）
            $place = Place::where('google_place_id', $google_place_id)->first();
        }

        $place_user_pref = PlaceUserPreference::where('google_place_id', $google_place_id)->where('user_id', $user_id)->where('status', 0)->first();
        if (is_null($place_user_pref)) {
            $place_user_pref = new PlaceUserPreference();
            $place_user_pref->user_id = $user_id;
            $place_user_pref->google_place_id = $google_place_id;
            $place_user_pref->place_type_id = $place_type_id;
            $place_user_pref->status = 0;
            $place_user_pref->save();
        } elseif ($place_type_id != $place_user_pref->place_type_id) {
            $place_user_pref->place_type_id = $place_type_id;
            $place_user_pref->save();
        }

        $place_id = $place->place_id;
        $criteria_order_exists = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->exists();
        if (!$criteria_order_exists) {
            $this->setCriteriaOrderDefaultValue($user_id, $place_type_id);
        }
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();

        foreach ($criteria_order as $order) {
            $criterion_id = $order->criterion_id;
            $criterion_input_name = 'criterion' . $order->display_order;

            $rating = Rating::where('user_id', $user_id)->where('place_id', $place_id)->where('criterion_id', $criterion_id)->where('status', 0)->first();
            if (is_null($rating)) {
                $rating = new Rating();
                $rating->user_id = $user_id;
                $rating->place_id = $place_id;
                $rating->criterion_id = $criterion_id;
                $rating->rating = $request->$criterion_input_name;
                $rating->status = 0;
            } else {
                $rating->rating = $request->$criterion_input_name;
            }
            $rating->save();

            $note = Note::where('user_id', $user_id)->where('place_id', $place_id)->where('status', 0)->first();
            if (is_null($note)) {
                $note = new Note();
                $note->user_id = $user_id;
                $note->place_id = $place_id;
                $note->note = $request->place_note;
                $note->status = 0;
            } else {
                $note->note = $request->place_note;
            }
            $note->save();
        }
        if (\Agent::isMobile()) {
            return redirect()->route('index_sp')->withInput();
        } else {
            return redirect()->route('index')->withInput();
        }
    }

    public function fetchAllPlacesLocations()
    {
        $user = Auth::user();
        $user_id = $user->user_id;
        $item = array();
        $items = array();

        $exists_rating = Rating::where('user_id', $user_id)->where('status', 0)->exists();
        if (!$exists_rating) {
            return json_encode('PLACE_NOT_FOUND');
        }
        $ratings = Rating::where('user_id', $user_id)->where('status', 0)->groupBy('place_id')->get();
        foreach ($ratings as $rating) {
            $item['google_place_id'] = $rating->place->google_place_id;
            $item['name'] = $rating->place->place_name;
            $item['latlng']['lat'] = $rating->place->latitude;
            $item['latlng']['lng'] = $rating->place->longitude;
            array_push($items, $item);
        }
        return json_encode($items);
    }
}
