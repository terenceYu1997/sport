<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建运动员信息
        Schema::create('playerinfo',function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('name')->index();
            $table->enum('sex',['男','女']);
            $table->uuid('group_id')->index();
            $table->string('num')->index();
            $table->string('tag');
            $table->foreign('group_id')->references('id')->on('groupinfo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('playerinfo');
    }
}
