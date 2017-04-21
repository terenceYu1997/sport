<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建赛事分组
        Schema::create('groupinfo',function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('name');
            $table->uuid('race_id');
            $table->foreign('race_id')->references('id')->on('raceinfo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('groupinfo');
    }
}
