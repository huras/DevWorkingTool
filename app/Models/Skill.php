<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';

    public $fillable = ['name', 'icon'];

    public function notes(){
        return $this->belongsToMany('App\Models\Note');
    }

    public function blocks(){
        return $this->belongsToMany('App\Models\Block');
    }

    public function parents (){
        return $this->belongsToMany('App\Models\Skill', 'skill_skill', 'child_id', 'parent_id');
    }
    public function childrens(){
        return $this->belongsToMany('App\Models\Skill', 'skill_skill', 'parent_id', 'child_id');
    }
}
