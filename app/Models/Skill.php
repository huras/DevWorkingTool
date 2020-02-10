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
}
