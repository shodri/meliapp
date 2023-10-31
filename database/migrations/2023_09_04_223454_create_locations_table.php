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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('address');
            $table->string('country');
            $table->string('province');
            $table->string('city');
            $table->string('lat');
            $table->string('long');
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('available');
            $table->string('meli_id')->nullable();

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
        Schema::dropIfExists('locations');
    }
};