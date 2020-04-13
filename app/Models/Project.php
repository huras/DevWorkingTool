<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $fillable = ['name', 'icon'];

    protected $table = 'projects';

    public function workdays()
    {
        return $this->belongsToMany('App\Models\Workday');
    }

    public function acessos()
    {
        return $this->belongsToMany('App\Models\Acesso');
    }
}
