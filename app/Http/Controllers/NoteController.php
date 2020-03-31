<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Note;
use App\Models\Workday;
use App\Models\Skill;

class NoteController extends Controller
{
    // Ajax Methods
    public function updateNote(Request $request)
    {
        $note = Note::find($request->id);
        if(isset($request->title))
            $note->title = $request->title;
        if(isset($request->type))
            $note->type = $request->type;
        if(isset($request->content))
            $note->content = $request->content;
        $note->save();
        return response()->json([
            'status' => true,
            'toast' => 'Nota atualizada com sucesso!',
            'toast-type' => 'job-done'
        ]);
    }

    public function removeNote(Request $request, $id){
        $note = Note::find($request->id);
        $note->delete();
        //Sends the note id back to the request sender
        return response()->json([
            'status' => true,
            'data' => $note,
            'toast' => 'Nota removida com sucesso!',
            'toast-type' => 'job-done'
        ]);
    }

    public function newNote(Request $request, $type)
    {
        //Create note
        $note = new Note;
        $note->title = '[New Note]';
        $note->content = '[empty]';
        $note->type = 'text';
        $note->save();

        //Links note to workday's id inside the request
        switch ($type) {
            case 'workday':
                $workday = Workday::find($request->id);
                $note->workdays()->save($workday);
                break;
            case 'skill':
                $skill = Skill::find($request->id);
                $note->skills()->save($skill);
                break;
            case 'block':
                $block = Block::find($request->id);
                $note->blocks()->save($block);
                break;

            default:
                # code...
                break;
        }

        //Sends the note id back to the request sender
        return response()->json([
            'status' => true,
            'data' => $note,
            'toast' => 'Nova nota criada com sucesso!',
            'toast-type' => 'job-done'
        ]);
    }

    public function newEmpty(Request $request, $relationship, $id, $type)
    {
        //Create note
        $note = new Note;
        $note->title = '[New Note]';
        $note->content = '[empty]';
        $note->type = $type;
        $note->save();

        //Links note to workday's id inside the request
        switch ($relationship) {
            case 'workday':
                $workday = Workday::find($id);
                $note->workdays()->save($workday);
                break;
            case 'skill':
                $skill = Skill::find($id);
                $note->skills()->save($skill);
                break;
            case 'block':
                $block = Block::find($id);
                $note->blocks()->save($block);
                break;

            default:
                # code...
                break;
        }

        //Sends the note id back to the request sender
        return redirect()->back();        
    }

    // Common Methods
}
