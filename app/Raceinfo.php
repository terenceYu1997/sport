<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raceinfo extends Model
{
    public $timestamps = false;
    protected $table = 'raceinfo';
    protected $fillable=['name','num','address','startime','endtime','type','typeinfo'];
}
