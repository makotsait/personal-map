<?php

namespace App\Http\Controllers;

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
        $items = PostRatings::all();
        return view('', ['items' => $items]);
    }

    public function createCriteriaOrder($user_id, $place_type_id)
    {
        // 1ユーザのデフォルトの表示順を設定をする
        for ($i = 1; $i <= 4; $i++) {
            $criteria_order = new CriteriaOrder();
            $criteria_order->user_id = $user_id;
            $criteria_order->place_type_id = $place_type_id;
            // ↓ここは要変更（まだplace_typeごとのcriteriaを決めてないため設定できない）
            $criteria_order->criterion_id = $i;
            $criteria_order->display_order = $i;
            $criteria_order->status = 0;
            $criteria_order->save();
        }
    }

    public function updateRatings(Request $request)
    {
        $user_id = $request->user_id;
        $google_place_id = $request->google_place_id;
        $place = Place::where('google_place_id', $google_place_id)->first();
        if (is_null($place)) {
            $api_key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
            $url = "https://maps.googleapis.com/maps/api/place/details/json?key={$api_key}&place_id={$google_place_id}&language=ja";
            $place_detail = json_decode(file_get_contents($url), true);
            $place_name = $place_detail["result"]["name"];
            $place_type_name_en = $place_detail["result"]["types"][0];
            $place_type = PlaceType::where('place_type_name_en', $place_type_name_en)->first();
            if (is_null($place_type)) {
                $place_type = new PlaceType();
                $place_type->place_type_name_en = $place_type_name_en;
                $place_type->status = 0;
                $place_type->save();
                $place_type = PlaceType::where('place_type_name_en', $place_type_name_en)->first();
            }
            $place_type_id = $place_type->place_type_id;

            $place = new Place();
            $place->google_place_id = $google_place_id;
            $place->place_name = $place_name;
            $place->place_type_id = $place_type_id;
            $place->status = 0;
            $place->save();
            $place = Place::where('google_place_id', $google_place_id)->first();
        }
        $place_id = $place->place_id;
        $place_type_id = $place->place_type_id;

        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();
        if (is_null($criteria_order)) {
            $this->createCriteriaOrder($user_id, $place_type_id);
            $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();
        }
        foreach ($criteria_order as $order) {
            $criterion_input_name = 'criterion' . $order->display_order;
            $criterion_id = $order->criterion_id;
            // 表示順序からcriterion_idを取得

            // $criterion = Place::where('criterion_name_en', $criteria_name)->first();

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
        return redirect('/');
    }
}
