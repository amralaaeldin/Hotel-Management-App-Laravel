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
            $table->unsignedSmallInteger('room_id');
            $table->unsignedMediumInteger('floor_id');
            $table->unsignedTinyInteger('duration');
            $table->unsignedDecimal('price_paid_per_day', 12, 2);
            $table->unsignedTinyInteger('accompany_number');
            $table->date('st_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('floor_id')->references('id')->on('floors');
            $table->foreign('room_id')->references('id')->on('rooms');
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
