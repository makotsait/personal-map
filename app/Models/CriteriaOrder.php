<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriteriaOrder extends Model
{
    protected $table = 'criteria_order';
    protected $primaryKey = 'criteria_order_id';
    protected $guarded = 'criteria_order_id';

    public function place_type()
    {
        return $this->belongsTo('PlaceType', 'place_type_id', 'place_type_id');
    }
}
