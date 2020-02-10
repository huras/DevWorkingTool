<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    public $fillable = ['content', 'title'];

    public function workdays(){
        return $this->belongsToMany('App\Models\Workday');
    }

    public function skills(){
        return $this->belongsToMany('App\Models\Skill');
    }
}
