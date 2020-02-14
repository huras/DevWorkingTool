<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workday extends Model
{
    protected $table = 'workdays';

    public $fillable = ['date'];
    public $timestamps = false;

    public function projects()
    {
        return $this->belongsToMany('App\Models\Project');
    }

    public function notes(){
        return $this->belongsToMany('App\Models\Note');
    }
}
