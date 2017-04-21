<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建运动员成绩信息
        Schema::create('score',function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('player_id')->index();
            $table->integer('node');
            $table->integer('childnode');
            $table->timestamp('time');
            $table->foreign('player_id')->references('id')->on('playerinfo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('score');
    }
}
