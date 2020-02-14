<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $items = PostRatings::all();
        return view('', ['items' => $items]);
    }

    public function createRatings(Request $request)
    {
        // レコード登録処理
        for ($i = 1; $i <= $request->num_criteria; $i++) {
            $post = new Ratings();
            $post->user_id = $request->user_id;
            $post->place_id = $request->place_id;
            $post->criterion_id = $request->criterion_id;
            $criterion = 'criterion' . $i;
            $post->rating = $request->$criterion;
            $post->status = 1;
            $post->save();
        }
        return redirect('/');
    }
    public function updateRatings(Request $request)
    {
        // $rating = Ratings::where('user_id',  $request->user_id)->where('place_id', $request->place_id)->where('criterion_id', $criterion_id)->first();
        // if (is_null($rating)) {
        // }
        for ($i = 1; $i <= $request->num_criteria; $i++) {

            $criterion_num = 'criterion' . $i;
            $criterion_id = $i;
            $rating = Rating::where('user_id',  $request->user_id)->where('place_id', $request->place_id)->where('criterion_id', $criterion_id)->first();
            if (is_null($rating)) {
                $rating = new Rating();
                $rating->user_id = $request->user_id;
                $rating->place_id = $request->place_id;
                $rating->criterion_id = $criterion_id;
                $rating->rating = $request->$criterion_num;
                $rating->status = 1;
            } else {
                $rating->rating = $request->$criterion_num;
            }
            $rating->save();
        }
        return redirect('/');
    }
}
