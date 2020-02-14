<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    // デフォルトが$primaryKey=idになっているので書き換える
    protected $primaryKey = 'rating_id';
    // rating_idへの書き込みを防ぐ
    protected $guarded = 'rating_id';

    public static $rules = array(
        'criterion1' => 'between:0,5',
        'criterion2' => 'between:0,5',
        'criterion3' => 'between:0,5',
        'criterion4' => 'between:0,5',
        'criterion5' => 'between:0,5',
        'criterion6' => 'between:0,5'
    );
}
