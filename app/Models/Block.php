<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'blocks';

    public $fillable = ['title'];

    public function notes()
    {
        return $this->belongsToMany('App\Models\Note');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill');
    }
}
