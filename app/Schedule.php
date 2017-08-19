<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable=[
        'id',
        'train_id',
        'city_id',
        'time',
        'schedule_type_id'
    ];
}
