<?php

namespace App\Http\Controllers;

use App\Raceinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaceinfoController extends Controller
{
    public function index(){
        return Raceinfo::all();
    }

    public function show($id){
        $raceinfo = Raceinfo::findOrFail($id);
        return $raceinfo;
    }

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
                ->select('playerinfo.id','raceinfo.id as raceinfoID','raceinfo.name as theLocation')//2.3.1查找当前运动员
                ->get();
                //获取到score表中具体的人员id,方便以下操作

//            dd($player_id);

            if ($player_id->count() !=0) {
                $score_info = DB::table('score')//------->查找成绩表所有信息
                    ->where('player_id', $player_id[0]->id)
                    ->get();

                $player_name = DB::table('playerinfo')//----->查找选手的个人信息
                    ->where('id', $player_id[0]->id)
                    ->get(['name','sex','num','tag']);
                $score_info[0]->name = $player_name[0]->name;
                $score_info[0]->sex = $player_name[0]->sex;
                $score_info[0]->num = $player_name[0]->num;
                $score_info[0]->tag = $player_name[0]->tag;


                $race_score_all = DB::table('raceinfo')//1.获取到所有小组内成员-->计算选手小组内成绩
                    ->where('num',$race_num)
                    ->get();

                $currentPlayerInfo = DB::table('raceinfo')//2.3.2 获取到当前运动员的所有信息
                    ->where('raceinfo.id',$player_id[0]->raceinfoID)
                    ->get();
                $currentPlayerScore = strtotime($currentPlayerInfo[0]->endtime)-strtotime($currentPlayerInfo[0]->startime);//2.3.3获取到当前运动员比赛用时.

                //2.计算出组内所有成员的用时--->将所有用时添加进数组--> 数组冒泡排序--->根据自己的成绩(比赛用时)-->查找出数组中对应成绩的下标--->获得排名.
                $currentArray = array();
                foreach ($race_score_all as $single){

                    if($single->type == 0 &&$score_info[0]->node >=1 && $score_info[0]->node >= $single->typeinfo ){//0-->圈跑
                        $singleScore = strtotime($single->endtime)-strtotime($single->startime);//2.1获取所有成员用时(/秒)
                        array_push($currentArray,$singleScore);
                    }else if($single->type == 1){
                        $singleScore = strtotime($single->endtime)-strtotime($single->startime);//2.1获取所有成员用时(/秒)
                        array_push($currentArray,$singleScore);
                    }
                };

                if($currentArray != null){
                    sort($currentArray);                 //2.2将数组排序
                    $currentPlayerRank = array_search($currentPlayerScore,$currentArray)+1;//由于索引从0计算
                }else{
                    $currentPlayerRank = '未完成比赛';
                }

                function changeTimeType($seconds){
                    if ($seconds > 3600){
                        $hours = intval($seconds/3600);
                        $minutes = $seconds % 3600;
                        $time = $hours.":".gmstrftime('%M:%S', $minutes);
                    }else{
                        $time = gmstrftime('%H:%M:%S', $seconds);
                    }
                    return $time;
                }


                $score_info[0]->grouprank = $currentPlayerRank;
                $score_info[0]->scoretime = changeTimeType($currentPlayerScore);
                $score_info[0]->Location = $player_id[0]->theLocation;


                return $score_info;
            } else {
                return 'z';

            }


        }else{
            return 'z';
        }

    }



}





