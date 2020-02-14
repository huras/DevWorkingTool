<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workday;
use App\Models\Skill;

class WorkdayController extends Controller
{
    public function index(){
        $workdays = Workday::orderBy('date', 'desc')->get();
        $skills = Skill::all();
        return view('Workday.index', compact('workdays', 'skills'));
    }

    public function store(Request $request){
        Workday::create($request->all());
        return back();
    }
}
