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
                ->select('playerinfo.id','raceinfo.id as raceinfoID','raceinfo.name as theLocation','playerinfo.group_id as theGroupName','raceinfo.type as theRaceType','raceinfo.typeinfo as theRaceNum')//2.3.1查找当前运动员
                ->get();
            //获取到score表中具体的人员id,方便以下操作

//            dd($player_id);

            if ($player_id->count() !=0) {
                $score_info = DB::table('score')//------->查找成绩表个人比赛用时(所有节点/时间)--->以后计算每个节点用时
                ->where('player_id', $player_id[0]->id)
                    ->get();

                $player_name = DB::table('playerinfo')//----->查找选手的个人信息
                ->where('id', $player_id[0]->id)
                    ->get(['name','sex','num','tag']);
                $score_info[0]->name = $player_name[0]->name;
                $score_info[0]->sex = $player_name[0]->sex;
                $score_info[0]->num = $player_name[0]->num;
                $score_info[0]->tag = $player_name[0]->tag;



                $race_number_all = DB::table('playerinfo')//1.获取到所有小组内成员-->计算选手小组内成绩
                ->where('playerinfo.group_id',$player_id[0]->theGroupName)
                    ->get();
//

                //2.计算出组内所有成员的用时--->将所有用时添加进数组--> 数组冒泡排序--->根据自己的成绩(比赛用时)-->查找出数组中对应成绩的下标--->获得排名.
                $currentPlayerInfo = DB::table('score')//2.3.2 获取到当前运动员的所有信息
                ->where('score.player_id',$player_id[0]->id)
                    ->get();

                //2.3.3获取到当前运动员比赛用时.
                $singleOrround = '';//--->判断是圈跑还是直线(0/圈 1/直)
                if($player_id[0]->theRaceType == 1){
                    $singleOrround = 'single';
                }
                else if($player_id[0]->theRaceType == 0){
                    $singleOrround = 'round';
                }

                if($singleOrround == 'single'){
                    //是否完成比赛-->判断有无节点2,节点1为起步,2为终点
                    if(count($currentPlayerInfo) >=2){
                        $currentPlayerScore = '';

                        $theCount = count($currentPlayerInfo);
                        //获得个人成绩
                        for($i=1;$i<$theCount;$i++){
                            $currentPlayerScore = strtotime($currentPlayerInfo[$i]->time) - strtotime($currentPlayerInfo[$i-1]->time);
                        }

                        //获取小组成绩
                        $groupScore = array();
                        foreach ($race_number_all as $singleNumber){//单个成员
                            $singlePlayerInfo = DB::table('score')//每个成员的所有节点信息
                            ->where('score.player_id',$singleNumber->id)
                                ->get();

                            for($i=1;$i<count($singlePlayerInfo);$i++){
                                $singlePlayerScore = strtotime($singlePlayerInfo[$i]->time) - strtotime($singlePlayerInfo[$i-1]->time);
                                array_push($groupScore,$singlePlayerScore);
                            }
                        }

                        if($groupScore != null){
                            sort($groupScore);                 //2.2将数组排序
                            $currentPlayerRank = array_search($currentPlayerScore,$groupScore)+1;//由于索引从0计算
                        }else{
                            $currentPlayerRank = '未完成比赛';
                        }


                        $score_info[0]->grouprank = $currentPlayerRank;
                        $score_info[0]->scoretime = changeTimeType($currentPlayerScore);
                        $score_info[0]->Location = $player_id[0]->theLocation;

                    }else{
                        return '未完成比赛';
                    }



                }
//--------------------------------------single end------------------------------------------------------------------------------
                else if($singleOrround == 'round'){
                    //是否完成比赛-->判断节点是否大于等于1(起步),是否大于等于raceinfo的typeinfo(跑完所有圈,完成比赛)
                    if(count($currentPlayerInfo) >= $player_id[0]->theRaceNum){
                        $currentPlayerScore = '';

                        $theCount = count($currentPlayerInfo);
                        //获得个人成绩
                        for($i=1;$i<$theCount;$i++){
                            $currentPlayerScore = strtotime($currentPlayerInfo[$theCount-1]->time)- strtotime($currentPlayerInfo[0]->time);
                        }
//

                        //获取小组成绩
                        $groupScore = array();
                        foreach ($race_number_all as $singleNumber){//单个成员
                            $singlePlayerInfo = DB::table('score')//每个成员的所有节点信息
                            ->where('score.player_id',$singleNumber->id)
                                ->get();

                            for($i=1;$i<count($singlePlayerInfo);$i++){
                                $singlePlayerScore = strtotime($singlePlayerInfo[$i]->time) - strtotime($singlePlayerInfo[$i-1]->time);
                                array_push($groupScore,$singlePlayerScore);
                            }
                        }

                        if($groupScore != null){
                            sort($groupScore);                 //2.2将数组排序
                            $currentPlayerRank = array_search($currentPlayerScore,$groupScore)+1;//由于索引从0计算
                        }else{
                            $currentPlayerRank = '未完成比赛';
                        }


                        $score_info[0]->grouprank = $currentPlayerRank;
                        $score_info[0]->scoretime = changeTimeType($currentPlayerScore);
                        $score_info[0]->Location = $player_id[0]->theLocation;



                    }

                }
                //2.3.3 end

                return $score_info;
            } else {
                return 'z';

            }


//            return $player_id;

        }else{
            return 'z';
        }

    }



}





