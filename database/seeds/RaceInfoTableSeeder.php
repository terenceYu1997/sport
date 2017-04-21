<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\RaceInfo;

class RaceInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //比赛信息填充
//        DB::table('raceinfo')->truncate();

        factory(RaceInfo::class,10)->create();

    }
}
