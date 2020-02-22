<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use Validator;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('name')->get();
        return view('Skill.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $validation = $this->validaSkill($request->all());
        if ($validation->fails()) {
            return back()
                ->withInput()
                ->withErrors($validation)
                ->with(
                    'toast',
                    [
                        'msg' => 'Erro! Preencha os campos corretamente!',
                        'context' => 'warning'
                    ]
                );
        } else {
            $skill = Skill::create($request->all());
            return redirect()
                ->action('SkillController@index')
                ->with('toast', ['msg' => $skill->name . ' inserido com sucesso!', 'context' => 'success']);
        }
    }

    function validaSkill($data)
    {
        $rules = [
            'name' => 'required',
            'icon' => 'file',
        ];

        if (!empty($data['icon-url'])) {
            $rules['icon-url'] = 'url';
        }

        $messages = [
            'name.required' => 'O campo nome é obrigatório',
            'file' => 'Arquivo inválido',
            'url' => 'URL inválida'
        ];

        return Validator::make($data, $rules, $messages);
    }

    // Ajax
    public function fetchAll($id)
    {
        $skill = Skill::find($id);
        $skill->notes = $skill->notes;
        $skill->blocks = $skill->blocks;
        foreach ($skill->blocks as $key => $block) {
            $skill->blocks[$key]->notes = $block->notes;
        }

        return response()
            ->json(
                [
                    'error' => false,
                    'data' => $skill
                ],
                200
            );
    }
}
