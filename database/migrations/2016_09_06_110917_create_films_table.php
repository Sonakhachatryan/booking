<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('duration');
            $table->string('genre');
            $table->string('directors');
            $table->string('producers');
            $table->string('writers');
            $table->string('studio');
            $table->string('formats');
            $table->string('trailer');
            $table->text('description');
            $table->text('casts');
            $table->string('avatar');
            $table->string('status');
            $table->integer('cinema_id');
            $table->softDeletes();
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
        Schema::drop('films');
    }
}
