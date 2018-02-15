<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_models';

    protected $fillable = ['make', 'model', 'year'];

    public function parts() {
        return $this->hasMany('App\CarModelPart', 'car_model_id');
    }
}
