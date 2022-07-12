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
            Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('number')->unique();
            $table->unsignedMediumInteger('floor_number');
            $table->unsignedTinyInteger('capacity');
            $table->unsignedDecimal('price', $precision = 9, $scale = 2);
            $table->unsignedBigInteger('created_by');
            $table->boolean('reserved')->default(false);
            $table->timestamps();

            $table->foreign('floor_number')->references('number')->on('floors');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
