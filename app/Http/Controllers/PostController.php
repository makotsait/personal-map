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

    public function insertCriteriaOrderDefaultValues($user_id, $place_type_id)
    {
        foreach ($this->default_criteria_order[$place_type_id] as $item) {
            $criteria_order = CriteriaOrder::create(['user_id'=>$user_id, 'place_type_id'=>$place_type_id,'criterion_id'=>$item[0],'display_order'=>$item[1]]);
        }
    }

    public function fetchPlaceDetails()
    {
        $google_place_id = $_GET['google_place_id'];

        $place_details = array();
        $place_details['google_place_id'] = $google_place_id;

        $place = Place::where('google_place_id', $google_place_id)->where('status', 0)->first();
        if (isset($place)) {
            $place_details['place_name']        = $place->place_name;
            $place_details['formatted_address'] = $place->formatted_address;
            $place_details["location"]["lat"]   = $place->latitude;
            $place_details["location"]["lng"]   = $place->longitude;
            $place_details['header_img_url']    = $place->default_header_img_url;
        } else {
            $place_api_controller = app()->make('App\Http\Controllers\PlaceApiController');
            $api_data = $place_api_controller->fetchPlaceDetails($google_place_id);

            $place_details['place_name']        = $api_data["result"]["name"];
            $place_details['formatted_address'] = $api_data["result"]["formatted_address"];
            $place_details["location"]["lat"]   = $api_data["result"]["geometry"]["location"]["lat"];
            $place_details["location"]["lng"]   = $api_data["result"]["geometry"]["location"]["lng"];
            $place_details['header_img_url']    = $place_api_controller->fetchHeaderImgUrl($api_data["result"]["photos"][0]["photo_reference"]);
        }
        
        return $place_details;
    }

    public function getPlaceTypeOptions()
    {
        $items = array();
        $place_types = PlaceType::all();
        foreach ($place_types as $i => $place_type) {
            $items['place_type_id'][$i]      = $place_type->place_type_id;
            $items['place_type_name_ja'][$i] = $place_type->place_type_name_ja;
        }
        return json_encode($items);
    }

    public function sortDisplayOrderAsc($criteria_order)
    {
        foreach ($criteria_order as $i => $each_order) {
            $display_order = $each_order[1];
            $sort[$i] = $display_order;
        }
        array_multisort($sort, SORT_ASC, $criteria_order);
        return $criteria_order;
    }

    public function set()
    {
    }

    public function createCriterionNameList()
    {
        $criterion_name_ls = array();
        $criterion_exists = Criterion::where('status', 0)->exists();
        if (!$criterion_exists) {
            return 'criterion not found in db';
        }
        $criteria = Criterion::where('status', 0)->get();
        foreach ($criteria as $criterion) {
            $criterion_name_ls[$criterion->criterion_id] = $criterion->criterion_name_ja;
        }
        return $criterion_name_ls;
    }

    public function setDefaultDisplayOrder($place_type_id, $criterion_name_ls, $criteria_order)
    {
        $items = array();
        foreach ($criteria_order as $i => $each_order) {
            $criterion_id = $each_order[0];
            $items['criterion_id'][$i]      = $criterion_id;
            $items['criterion_name_ja'][$i] = $criterion_name_ls[$criterion_id];
            $items['ratings'][$i]           = 0;
        }
        return $items;
    }

    public function setPlaceUserPref($google_place_id, $user_id, $place)
    {
        $place_user_pref = PlaceUserPreference::where('google_place_id', $google_place_id)->where('user_id', $user_id)->where('status', 0)->first();
        if (isset($place_user_pref)) {
            return $place_user_pref->place_type_id;
        } elseif (is_null($place_user_pref)) {
            return $place->default_place_type_id;
        }
    }

    public function fetchRatings()
    {
        $google_place_id = $_GET['google_place_id'];
        $user_id = Auth::user()->user_id;
        $items = array();

        $criterion_name_ls = $this->createCriterionNameList();

        foreach ($this->default_criteria_order as $place_type_id => $criteria_order) {
            $criteria_order = $this->sortDisplayOrderAsc($criteria_order);
            $items['default_order'][$place_type_id] = $this->setDefaultDisplayOrder($place_type_id, $criterion_name_ls, $criteria_order);
        }

        $place = Place::where('google_place_id', $google_place_id)->where('status', 0)->first();
        if (is_null($place)) {
            $items['user_order'][0] = '';
            $items['note'] = '';
            return $items;
        }

        $place_id = $place->place_id;

        $items['place_type_id'] = $this->setPlaceUserPref($google_place_id, $user_id, $place);

        $criteria_order_exists = CriteriaOrder::where('user_id', $user_id)->where('status', 0)->exists();
        if (!$criteria_order_exists) {
            return 'criteria_order not found in db';
        }
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('status', 0)->orderBy('display_order', 'asc')->orderBy('place_type_id', 'asc')->get();
        foreach ($criteria_order as $each_order) {
            $items['user_order'][$each_order->place_type_id]['criterion_id'][]      = $each_order->criterion_id;
            $items['user_order'][$each_order->place_type_id]['criterion_name_ja'][] = $each_order->criterion->criterion_name_ja;
            $rating = Rating::where('user_id', $user_id)->where('place_id', $place_id)->where('criterion_id', $each_order->criterion_id)->first();
            $rating_value = isset($rating)? $rating->rating : 0;
            $items['user_order'][$each_order->place_type_id]['ratings'][] = $rating_value;
        }

        $note = Note::where('user_id', $user_id)->where('place_id', $place_id)->first();
        $items['note'] = isset($note)? $note->note : '';

        return json_encode($items);
    }

    public function createPlace($google_place_id, $request)
    {
        $place = Place::create(['google_place_id'=>$google_place_id, 'place_name'=>$request->form_place_name,'formatted_address'=>$request->form_formatted_address,
            'latitude'=>$request->form_latitude,'longitude'=>$request->form_longitude,'default_place_type_id'=>1,'default_header_img_url'=>$request->form_header_img_url]);
        // [todo]place_apiから取得したjsonにplace_typeが複数入力されているので、マッチしたタイプ名のidをdefault_type_idとして入れる機能の実装
        return $place;
    }

    public function setUserPref($user_id, $google_place_id, $place_type_id)
    {
        $place_user_pref = PlaceUserPreference::where('user_id', $user_id)->where('google_place_id', $google_place_id)->where('status', 0)->first();
        if (is_null($place_user_pref)) {
            $place_user_pref = PlaceUserPreference::create(['user_id'=>$user_id, 'google_place_id'=>$google_place_id,'place_type_id'=>$place_type_id]);
        } elseif ($place_type_id != $place_user_pref->place_type_id) {
            $place_user_pref->fill(['place_type_id' => $place_type_id]);
            $place_user_pref->save();
        }
    }

    public function setUserRaging($user_id, $place_id, $criterion_id, $new_rating)
    {
        $rating = Rating::where('user_id', $user_id)->where('place_id', $place_id)->where('criterion_id', $criterion_id)->where('status', 0)->first();
        if (is_null($rating)) {
            $rating = Rating::create(['user_id'=>$user_id, 'place_id'=>$place_id,'criterion_id'=>$criterion_id,'rating'=>$new_rating]);
        } elseif ($rating->rating !=  $new_rating) {
            $rating->fill(['rating' => $new_rating]);
            $rating->save();
        }
    }

    public function setUserNote($user_id, $place_id, $new_note)
    {
        $note = Note::where('user_id', $user_id)->where('place_id', $place_id)->where('status', 0)->first();
        if (is_null($note)) {
            $note = Note::create(['user_id'=>$user_id, 'place_id'=>$place_id,'note'=>$new_note]);
        } elseif ($note->note != $new_note) {
            $note->fill(['note' => $new_note]);
            $note->save();
        }
    }

    public function updateRatings(Request $request)
    {
        $user = Auth::user();

        $user_id         = $user->user_id;
        $google_place_id = $request->google_place_id;
        $place_type_id   = $request->form_place_type_id;

        $place = Place::where('google_place_id', $google_place_id)->first();
        if (is_null($place)) {
            $place = $this->createPlace($google_place_id, $request);
        }
        $place_id = $place->place_id;

        $this->setUserPref($user_id, $google_place_id, $place_type_id);

        $criteria_order_exists = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->exists();
        if (!$criteria_order_exists) {
            $this->insertCriteriaOrderDefaultValues($user_id, $place_type_id);
        }
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();
        foreach ($criteria_order as $order) {
            $criterion_id        = $order->criterion_id;
            $criterion_name_text = 'criterion' . $order->display_order;
            $this->setUserRaging($user_id, $place_id, $criterion_id, $request->$criterion_name_text);
        }

        $this->setUserNote($user_id, $place_id, $request->place_note);

        if (\Agent::isMobile()) {
            return redirect()->route('index.sp')->withInput()->with('is_with_input', true);
        } else {
            return redirect()->route('index')->withInput();
        }
    }

    public function fetchAllPlacesLocations()
    {
        $user = Auth::user();
        $user_id = $user->user_id;
        $item  = array();
        $items = array();

        $exists_rating = Rating::where('user_id', $user_id)->where('status', 0)->exists();
        if (!$exists_rating) {
            return json_encode('PLACE_NOT_FOUND');
        }
        $ratings = Rating::where('user_id', $user_id)->where('status', 0)->groupBy('place_id')->get();
        foreach ($ratings as $rating) {
            $item['google_place_id'] = $rating->place->google_place_id;
            $item['name']            = $rating->place->place_name;
            $item['latlng']['lat']   = $rating->place->latitude;
            $item['latlng']['lng']   = $rating->place->longitude;
            array_push($items, $item);
        }
        return json_encode($items);
    }
}
