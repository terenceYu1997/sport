<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupinfo extends Model
{
    public $timestamps = false;
    protected $table = 'groupinfo';
    protected $fillable=['name','race_id'];
}
