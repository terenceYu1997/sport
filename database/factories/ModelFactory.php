<?php



/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


//比赛信息表
$factory->define(App\RaceInfo::class,function(Faker\Generator $faker){
    return [
        'id'=>$faker->uuid,
        'name' => $faker->name,
        'num' => $faker->numberBetween($min = 1000, $max = 9000),
        'address' => $faker->address,
        'startime'=>$faker->date($format = 'Y-m-d', $max = 'now'),
        'endtime'=>$faker->date($format = 'Y-m-d', $max = 'now'),
        'type'=>$faker->randomDigit,
        // 'typeinfo'=>$faker->realText($maxNbChars = 200, $indexSize = 2)
    ] ;
});

//分组信息表
$factory->define(App\GroupInfo::class,function(Faker\Generator $faker){
//    $race_ids = \App\RaceInfo::pluck('id')->random();
//    $race_ids = \App\RaceInfo::pluck('id');

    $race_ids = DB::table('raceinfo')->pluck('id')->random();

    return [
        'id'=>$faker->uuid,
        'name' => $faker->name,
        'race_id'=>$race_ids
    ] ;
});

//运动员信息表
$factory->define(App\PlayerInfo::class,function(Faker\Generator $faker){
    $group_ids = DB::table('groupinfo')->pluck('id')->random();
    return [
        'id'=>$faker->uuid,
        'name' => $faker->name,
//        'sex' => $faker->title($gender = null|'male'|'female'),
        'group_id' => $group_ids,
        'num'=>$faker->randomDigit,
        'tag'=>$faker->md5
    ] ;
});

//成绩表
$factory->define(App\Score::class,function(Faker\Generator $faker){
    $player_ids = DB::table('playerinfo')->pluck('id')->random();
    return [
        'id'=>$faker->uuid,
        'player_id' =>$player_ids,
        'node' => $faker->numberBetween($min = 0, $max = 2),
        'childnode' => $faker->numberBetween($min = 0, $max = 2),
        'time'=>$faker->dateTime($max = 'now', $timezone = date_default_timezone_get())
    ] ;
});

