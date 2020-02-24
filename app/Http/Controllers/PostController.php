<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Place;
use App\Models\Criterion;
use App\Models\CriteriaOrder;
use App\Models\Note;
use App\Models\PlaceType;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // $items = PostRatings::all();
        // return view('', ['items' => $items]);
    }
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setCriteriaOrderDefaultValue($user_id, $place_type_id)
    {
        // [[place_type_id]=>[[criterion_id,display_order]]]
        $default_set = array(
            '1' => array([1, 1], [2, 2], [6, 3], [4, 4]),
            '2' => array([3, 1], [2, 2], [1, 3], [4, 4]),
            '3' => array([7, 1], [8, 2], [5, 3], [6, 4]),
            '4' => array([3, 1], [2, 2], [5, 3], [6, 4]),
            '5' => array([10, 1], [2, 2], [9, 3], [4, 4]),
            '6' => array([3, 1], [5, 2], [9, 3], [4, 4]),
            '7' => array([10, 1], [2, 2], [9, 3], [4, 4]),
            '8' => array([11, 1], [12, 2], [5, 3], [3, 4])
        );
        foreach ($default_set[$place_type_id] as $item) {
            $criteria_order = new CriteriaOrder();
            $criteria_order->user_id = $user_id;
            $criteria_order->place_type_id = $place_type_id;
            $criteria_order->criterion_id = $item[0];
            $criteria_order->display_order = $item[1];
            $criteria_order->status = 0;
            $criteria_order->save();
        }
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
        $user = Auth::user();
        $user_id = $user->user_id;
        $google_place_id = $_GET['google_place_id'];
        $place = Place::where('google_place_id', $google_place_id)->where('status', 0)->first();
        if (is_null($place)) return 'place not found in db';

        $items = array();
        $place_id = $place->place_id;
        $place_type_id = $place->place_type_id;

        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->orderBy('display_order', 'asc')->first();
        // if (is_null($criteria_order)) {
        //     $this->createCriteriaOrder($user_id, $place_type_id);
        //     $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();
        // }
        if (is_null($criteria_order)) return 'criteria_order not found in db';
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->orderBy('display_order', 'asc')->get();
        $i = 0;
        foreach ($criteria_order as $order) {
            $rating = Rating::where('user_id',  $user_id)->where('place_id', $place_id)->where('criterion_id', $order->criterion_id)->first();
            if (is_null($rating)) return 'rating not found in db';
            $i++;
            $items['rating'][$i]['criterion_name'] = $rating->criterion->criterion_name_en;
            $items['rating'][$i]['rating'] = $rating->rating;
        }
        $items['num_of_criteria'] = $i;

        $note = Note::where('user_id',  $user_id)->where('place_id', $place_id)->first();
        if (is_null($criteria_order)) return 'note not found in db';
        $items['note'] = $note->note;

        // 施設タイプ一覧の取得(メソッドを作る予定)
        $place_types = PlaceType::all();
        $i = 0;
        foreach ($place_types as $place_type) {
            $items['place_types'][$i] = $place_type->place_type_name_ja;
            $i++;
        }
        return json_encode($items);
    }

    public function updateRatings(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->user_id;
        $google_place_id = $request->google_place_id;
        $place_name =  $request->form_place_name;
        $place_type_id = $request->form_place_type_id;
        // $place_type_id = $_GET['place_type_id'];
        $place = Place::where('google_place_id', $google_place_id)->first();
        if (is_null($place)) {
            // 施設の追加
            // $api_key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
            // $url = "https://maps.googleapis.com/maps/api/place/details/json?key={$api_key}&place_id={$google_place_id}&language=ja";
            // $place_detail = json_decode(file_get_contents($url), true);
            // $place_name = $place_detail["result"]["name"];
            $place = new Place();
            $place->google_place_id = $google_place_id;
            $place->place_name = $place_name;
            $place->place_type_id = $place_type_id;
            $place->status = 0;
            $place->save();
            $place = Place::where('google_place_id', $google_place_id)->first();
        }
        if ($place->place_name != $place_name) {
            $place->place_name = $place_name;
            $place->save();
        }
        if ($place->place_type_id != $place_type_id) {
            $place->place_type_id = $place_type_id;
            $place->save();
        }
        $place_id = $place->place_id;
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->first();
        // **->get()でコレクションを取得して、emptyで空か判定する形はうまく動作しなかったため、一旦first()でモデルを取得して判定する形にした**
        if (is_null($criteria_order)) {
            $this->setCriteriaOrderDefaultValue($user_id, $place_type_id);
        }
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();

        foreach ($criteria_order as $order) {
            $criterion_id = $order->criterion_id;
            $criterion_input_name = 'criterion' . $order->display_order;
            // 表示順序からcriterion_idを取得

            $rating = Rating::where('user_id',  $user_id)->where('place_id', $place_id)->where('criterion_id', $criterion_id)->first();
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

            $note = Note::where('user_id',  $user_id)->where('place_id', $place_id)->first();
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
        return redirect()->route('index')->withInput();
    }
}
