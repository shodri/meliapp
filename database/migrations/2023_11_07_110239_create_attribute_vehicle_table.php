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
        Schema::create('attribute_vehicle', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attribute_id')->unsigned();
            $table->bigInteger('vehicle_id')->unsigned();
            $table->string('value');
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('attribute_id')->references('id')->on('attributes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_vehicle');
    }
};
