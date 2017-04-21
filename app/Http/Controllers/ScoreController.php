<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function store(Request $request){
//        $aaa = $request->json('playerNum');

        //比赛信息编码
        $race_num = $request->json('raceNum');
        //运动员编码
        $player_num = $request->json('playerNum');

        $back_score_time = null;

        if($race_num != null) {
            $player_id = DB::table('raceinfo')
                ->join('groupinfo', 'raceinfo.id', 'groupinfo.race_id')
                ->join('playerinfo', 'playerinfo.group_id', 'groupinfo.id')
                ->where('playerinfo.num', '=', $player_num)
                ->where('raceinfo.num', '=', $race_num)
                ->select('playerinfo.id')
                ->get();

//            dd($player_id);

            if ($player_id) {
                $score_time = DB::table('score')
                    ->where('player_id', $player_id[0]->id)
                    ->get(['time']);
                $back_score_time = $score_time[0]->time;
                return $player_id;
            } else {
                return 'FKFKF';
            }


        }

    }
}
