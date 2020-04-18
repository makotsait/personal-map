<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $primaryKey = 'note_id';
    protected $guarded = ['note_id'];
}
