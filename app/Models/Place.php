<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $primaryKey = 'place_id';
    protected $guarded = ['place_id'];
}
