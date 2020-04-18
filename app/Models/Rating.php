<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    // デフォルトが$primaryKey=idになっているので書き換える
    protected $primaryKey = 'rating_id';
    // rating_idへの書き込みを防ぐ
    protected $guarded = ['rating_id'];

    public static $rules = array(
        'criterion1' => 'between:0,5',
        'criterion2' => 'between:0,5',
        'criterion3' => 'between:0,5',
        'criterion4' => 'between:0,5',
        'criterion5' => 'between:0,5',
        'criterion6' => 'between:0,5'
    );
    // public function user()
    // {
    //     return $this->belongsTo('User', 'user_id', 'user_id');
    // }
    // public function place()
    // {
    //     return $this->belongsTo('Place', 'place_id', 'place_id');
    // }
    public function criterion()
    {
        return $this->belongsTo('App\Models\Criterion', 'criterion_id', 'criterion_id');
    }
    public function place()
    {
        return $this->belongsTo('App\Models\Place', 'place_id', 'place_id');
    }
    // public function criteria_order()
    // {
    //     return $this->belongsTo('CriteriaOrder', 'criteria_order_id', 'criteria_order_id');
    // }
}
