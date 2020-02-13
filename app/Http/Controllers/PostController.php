<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ratings;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $items = PostRatings::all();
        return view('', ['items' => $items]);
    }

    public function createRatings(Request $request)
    {
        //バリデーション
        $validatedData = $request->validate([
            // 'title' => 'required|string|max:200',
            'criterion1' => 'between:0,5',
            'criterion2' => 'between:0,5',
            'criterion3' => 'between:0,5',
            'criterion4' => 'between:0,5'
        ]);
        // レコード登録処理
        $post = new Ratings();
        $post->user_id = $request->user_id;
        $post->place_id = $request->place_id;
        $post->criterion_id = $request->criterion_id;
        $post->rating = $request->criterion1;
        $post->status = 1;
        $post->save();
        return redirect('/');
    }
    public function updateRatings(Request $request)
    {
        $rating = Ratings::where('user_id',  $request->user_id)->where('place_id', $request->place_id)->where('criterion_id', $request->criterion_id)->first();
        if (is_null($rating)) {
            $this->createRatings($request);
        } else {
            $rating->rating = $request->criterion1;
            $rating->status = 1;
            $rating->save();
        }
        return redirect('/');
    }
}
