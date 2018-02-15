<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModelPart extends Model
{
    protected $table = 'car_model_parts';

    public function carModel () {
        return $this->belongsTo('App\CarModel', 'car_model_id');
    }

    public function carModelPartDetails() {
        return $this->hasMany('App\CarModelPartDetails', 'car_model_part_id');
    }
}
