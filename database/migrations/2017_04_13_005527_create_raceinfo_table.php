<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建比赛信息表
        Schema::create('raceinfo',function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('name')->index();
            $table->string('num')->index();
            $table->string('address');
            $table->timestamp('startime');
            $table->timestamp('endtime')->nullable()->index();
            $table->integer('type');
            $table->json('typeinfo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('raceinfo');
    }
}
