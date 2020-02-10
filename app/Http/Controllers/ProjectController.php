<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::orderBy('name', 'asc')->get();
        return view('Project.index', compact('projects'));
    }
}
