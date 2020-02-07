<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Note;

class NoteController extends Controller
{
    // Ajax Methods
    public function updateNote(Request $request){
        $note = Note::find($request->id);
        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();
    }

    // Common Methods
}
