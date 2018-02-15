<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModelPartDetail extends Model
{
    protected $table = 'car_model_part_details';

    public function carModelPart () {
        return $this->belongsTo('App\CarModelPart', 'car_model_part_id');
    }
}
