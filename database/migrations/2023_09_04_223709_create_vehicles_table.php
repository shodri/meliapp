<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('model_id')->unsigned();
            $table->bigInteger('version_id')->unsigned();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('fuel_id')->unsigned();
            $table->bigInteger('location_id')->unsigned();
            $table->bigInteger('segment_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('color');
            $table->integer('kilometers');
            $table->integer('price');
            $table->integer('year');
            $table->longText('description')->nullable();
            $table->string('comments', 1000)->nullable();
            $table->bigInteger('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('active');
            $table->string('meli_link')->nullable();
            $table->string('meli_id')->nullable();

            // $table->string('ml_id');
            // $table->string('ml_link');
            // $table->string('ml_instance');


            $table->softDeletes();
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('vehicle_brands');
            $table->foreign('model_id')->references('id')->on('vehicle_models');
            $table->foreign('version_id')->references('id')->on('vehicle_versions');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('fuel_id')->references('id')->on('fuels');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
