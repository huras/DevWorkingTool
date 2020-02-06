<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workday;

class WorkdayController extends Controller
{
    public function index(){
        $workdays = Workday::all();
        return view('Workday.index', compact('workdays'));
    }
}
