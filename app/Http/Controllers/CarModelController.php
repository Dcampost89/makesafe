<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CarModel;
use App\CarModelPart;
use App\CarModelPartDetail;
use App\CarModelDetailedInfo;

class CarModelController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function storeParts(Request $request) {
        //dd($request->all());
        foreach ($request->all() as $row) {
            //dd($row);
            $model = new CarModel;
            $model->make = $row['maker'];
            $model->model = $row['model'];
            $model->year =$row['year'];
            $model->save();
            
            foreach ($row['parts'] as $part) {
                $modelPart = new CarModelPart;
                $modelPart->car_model_id = $model->id;
                $modelPart->name = $part['name'];
                $modelPart->save();

                foreach ($part['details'] as $detail) {
                    $modelPartDetail = new CarModelPartDetail;
                    $modelPartDetail->car_model_part_id = $modelPart->id;
                    $modelPartDetail->name = $detail;
                    $modelPartDetail->save();
                }
            }

            foreach ($row['detail'] as $detailed_info) {
                $modelDetailedInfo = new CarModelDetailedInfo;
                $modelDetailedInfo->car_model_id = $model->id;
                $modelDetailedInfo->parameter = $detailed_info['parameter'];
                $modelDetailedInfo->value = $detailed_info['value'];
                $modelDetailedInfo->save();
            }
        }

        return $this->success('Parts successfully added', [], 200);
    }
}
