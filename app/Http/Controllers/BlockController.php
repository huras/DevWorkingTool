<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Skill;
use Exception;
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

    public function newEmpty(Request $request, $relationship, $id)
    {
        $block = new Block;
        $block->title = '[New Block]';
        $block->save();

        switch ($relationship) {
            case 'skill':
                $skill = Skill::find($id);
                $block->skills()->save($skill);
                break;
        }

        return redirect()->back();
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

    public function newSkillLink(Request $request, $idBlock, $idSkill)
    {
        try{
            $skill = Skill::find($idSkill);
            $block = Block::find($idBlock);
            $block->skills()->save($skill);
            return response()->json([
                'status' => true,
                'toast' => 'Nova skill inserida com sucesso!',
                'toast-type' => 'job-done'
            ]);
        } catch(Exception $ex){
            return response()->json([
                'status' => false,
                'toast' => $ex->getMessage(),
                'toast-type' => 'job-done'
            ], 500);
        }
    }
}
