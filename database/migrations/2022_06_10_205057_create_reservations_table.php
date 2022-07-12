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
            Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedSmallInteger('room_number');
            $table->unsignedMediumInteger('floor_number');
            $table->unsignedTinyInteger('duration');
            $table->unsignedDecimal('price_paid_per_day', $precision = 9, $scale = 2);
            $table->unsignedTinyInteger('accompany_number');
            $table->date('st_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('floor_number')->references('number')->on('floors');
            $table->foreign('room_number')->references('number')->on('rooms');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservatoins');
    }
};
