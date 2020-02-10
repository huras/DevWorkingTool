<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Note;
use App\Models\Workday;

class NoteController extends Controller
{
    // Ajax Methods
    public function updateNote(Request $request){
        $note = Note::find($request->id);
        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();
    }

    public function newWorkdaynote(Request $request){
        //Create note
        $note = new Note;
        $note->title = '[New Note]';
        $note->content = '[empty]';
        $note->save();

        //Links note to workday's id inside the request
        $workday = Workday::find($request->id);
        $note->workdays()->save($workday);

        //Sends the note id back to the request sender
        return response()->json(['status' => true, 'data' => $note, 'toast' => 'Nova nota criada com sucesso!', 'toast-type' => 'job-done']);
    }

    // Common Methods
}
