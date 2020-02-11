<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class AcessoController extends Controller
{
    public function projects(){
        $projects = Project::orderBy('name', 'asc')->get();
        return view('Acesso.projects', compact('projects'));
    }
}
