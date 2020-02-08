<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workday;

class WorkdayController extends Controller
{
    public function index(){
        $workdays = Workday::orderBy('date', 'desc')->get();
        return view('Workday.index', compact('workdays'));
    }
}
