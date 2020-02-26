<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriteriaOrder extends Model
{
    protected $table = 'criteria_order';
    protected $primaryKey = 'criteria_order_id';
    protected $guarded = 'criteria_order_id';

    public function criterion()
    {
        return $this->belongsTo('Criterion', 'criterion_id', 'criterion_id');
    }
}
