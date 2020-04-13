<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acesso extends Model
{
    public $fillable = ['title', 'user', 'password', 'address'];

    public function projetos()
    {
        return $this->belongsToMany('App\Models\Project');
    }
}
