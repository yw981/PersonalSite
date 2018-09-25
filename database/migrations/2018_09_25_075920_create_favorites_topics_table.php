<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_topic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('favorite_id')->unsigned()->index();
            $table->foreign('favorite_id')->references('id')->on('favorites')->onDelete('cascade');
            $table->integer('topic_id')->unsigned()->index();
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
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
        Schema::dropIfExists('favorite_topic');
    }
}
