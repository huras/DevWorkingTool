<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    public function workdays()
    {
        return $this->belongsToMany('App\Models\Workday');
    }
}
