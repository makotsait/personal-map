<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

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

    public function insertPlace($google_place_id)
    {
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
    }

    public function createCriteriaOrder($user_id, $place_type_id)
    {

        // $criterion_id_list = [1, 2, 3, 4];
        // foreach ($criterion_id_list as $criterion_id) {
        // }
        // =>criterionを作成する部分は別に記載

        // 1ユーザのデフォルトの表示順を設定をする
        for ($i = 1; $i <= 4; $i++) {
            $criteria_order = new CriteriaOrder();
            $criteria_order->user_id = $user_id;
            $criteria_order->place_type_id = $place_type_id;
            // ↓ここは要変更（まだplace_typeごとのcriteriaを決めてないため設定できない）
            $criteria_order->criterion_id = $i;
            $criteria_order->display_order = $i;
            // -----
            $criteria_order->status = 0;
            $criteria_order->save();
        }
    }

    public function getRatings()
    {
        $user_id = $_GET['user_id'];
        $google_place_id = $_GET['google_place_id'];
        $place = Place::where('google_place_id', $google_place_id)->where('status', 0)->first();
        $rating = Rating::where('user_id',  $user_id)->where('place_id', $place->place_id)->where('status', 0)->first();
        if (is_null($rating)) {
            return 'nodata';
        }
        // Log::info($place_id);
        // Log::info($place_type_id);

        $items = array();
        $place_id = $place->place_id;
        $place_type_id = $place->place_type_id;

        // return json_encode(array($user_id, $place_type_id));
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->orderBy('display_order', 'asc')->first();
        // if (is_null($criteria_order)) {
        //     $this->createCriteriaOrder($user_id, $place_type_id);
        //     $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();
        // }
        if (!is_null($criteria_order)) {
            $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->orderBy('display_order', 'asc')->get();
            $i = 0;
            foreach ($criteria_order as $order) {
                $rating = Rating::where('user_id',  $user_id)->where('place_id', $place_id)->where('criterion_id', $order->criterion_id)->first();
                if (!is_null($rating)) {
                    $i++;
                    $items['rating'][$i]['criterion_name'] = $rating->criterion->criterion_name_en;
                    $items['rating'][$i]['rating'] = $rating->rating;
                }
            }
            $items['num_of_criteria'] = $i;
        }

        $note = Note::where('user_id',  $user_id)->where('place_id', $place_id)->first();
        if (isset($note)) {
            $items['note'] = $note->note;
        } else {
            $items['note'] = '';
        }
        // $json = json_encode(array(
        //     "foo" => "bar",
        //     "bar" => "foo",
        // ));
        return json_encode($items);
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
        Log::info('user_id: ' . $user_id);
        Log::info('place_type_id: ' . $place_type_id);
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->first();
        // $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();
        // **get()でコレクションを取得して、emptyで空か判定する形ではうまく動作しなかったため、一旦first()でモデルを取得して判定する形にした**
        Log::info(var_dump($criteria_order));
        Log::info('before_criteria_order2');
        // get()でコレクションを取得して、emptyで空か判定する形ではうまく動作しなかったため、一旦first()でモデルを取得して判定する形にした
        if (is_null($criteria_order)) {
            // if (is_null($criteria_order)) {
            Log::info('in_criteria_order2');
            $this->createCriteriaOrder($user_id, $place_type_id);
        }
        $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();

        Log::info('after_criteria_order2');
        // $criteria_order = CriteriaOrder::where('user_id', $user_id)->where('place_type_id', $place_type_id)->where('status', 0)->get();
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
                // $rating->rating = $request->criterion1;
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
