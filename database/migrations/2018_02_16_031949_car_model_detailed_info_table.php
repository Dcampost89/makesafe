<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarModelDetailedInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_model_detailed_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_model_id')->unsigned();
            $table->foreign('car_model_id')->references('id')->on('car_models')->onDelete('cascade');
            $table->string('parameter');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_model_detailed_info');
    }
}
