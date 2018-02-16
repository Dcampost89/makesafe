<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModelDetailedInfo extends Model
{
    protected $table = 'car_model_detailed_info';

    public function carModel () {
        return $this->belongTo('App\CarModel', 'car_model_id');
    }

}
