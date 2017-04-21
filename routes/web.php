<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', function () {//这里不需要返回一个控制器,直接返回一个具体的试图--->接下来的路由跳转有vue完成
    return view('search');
});
Route::get('/YGWLaddscore', function () {//这里不需要返回一个控制器,直接返回一个具体的试图--->接下来的路由跳转有vue完成
    return view('addscore');
});


Route::group(['prefix'=>'api/v1'],function (){
    Route::resource('raceinfo','RaceinfoController');
    Route::resource('addscore','ScoreController');
});

