<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function index(){
       $skills = Skill::orderBy('name')->get();
        return view('Skill.index', compact('skills'));
    }

    public function getDetails(Request $request){
        $id = $request->id;
        $skill = Skill::find($id);
        $skill->notes = $skill->notes;
        return response()->json($skill, 200);
    }
}
