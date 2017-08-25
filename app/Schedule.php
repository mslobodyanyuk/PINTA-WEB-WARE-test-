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

    public function train(){
        return $this->belongsTo('App\Train');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function scheduleType(){
        return $this->belongsTo('App\ScheduleType');
    }
}
