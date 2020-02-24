<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Skill;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function new(Request $request, $relationship)
    {
        $block = new Block;
        $block->title = '[New Block]';
        $block->save();

        switch ($relationship) {
            case 'skill':
                $skill = Skill::find($request->id);
                $block->skills()->save($skill);
                break;
        }

        return response()
            ->json(
                [
                    'error' => false,
                    'data' => $block,
                    'toast' => [
                        'msg' => 'Novo bloco criado com sucesso!',
                        'context' => 'success'
                    ]
                ],
                200
            );
    }

    public function updateAjax(Request $request)
    {
        $block = Block::find($request->id);
        $block->title = $request->title;
        $block->save();
        return response()->json([
            'status' => true,
            'toast' => 'Bloco atualizado com sucesso!',
            'toast-type' => 'job-done'
        ]);
    }
}
