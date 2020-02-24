<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    public $fillable = ['content', 'title', 'type'];

    public function workdays()
    {
        return $this->belongsToMany('App\Models\Workday');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill');
    }

    public function blocks()
    {
        return $this->belongsToMany('App\Models\Block');
    }
}
