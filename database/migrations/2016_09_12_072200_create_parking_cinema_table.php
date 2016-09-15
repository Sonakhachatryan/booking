<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingCinemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_cinema', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parking_id')->unsigned();
            $table->foreign('parking_id')
                ->references('id')
                ->on('parkings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('cinema_id')->unsigned();
            $table->foreign('cinema_id')
                ->references('id')
                ->on('cinemas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('total_count');
            $table->integer('available_for_order');
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
        Schema::drop('parking_cinema');
    }
}
