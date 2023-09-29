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
            $table->smallIncrements('id')->unique();
            $table->unsignedMediumInteger('floor_id');
            $table->unsignedTinyInteger('capacity');
            $table->unsignedDecimal('price', 12, 2);
            $table->unsignedBigInteger('created_by');
            $table->boolean('reserved')->default(false);
            $table->timestamps();

            $table->foreign('floor_id')->references('id')->on('floors');
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
