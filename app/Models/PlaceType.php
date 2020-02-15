<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceType extends Model
{
    protected $table = 'place_types';
    protected $primaryKey = 'place_type_id';
    protected $guarded = 'place_type_id';
}
