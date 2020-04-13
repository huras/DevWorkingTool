<?php

namespace App\Http\Controllers;

use App\Models\Acesso;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Image;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::orderBy('name', 'asc')->get();
        return view('Project.index', compact('projects'));
    }

    public function acessos($id){
        $project = Project::find($id);
        $acessos = $project->acessos;
        return view('Acesso.list', compact('acessos', 'project'));   
    }

    public function storeAcesso(Request $request, $id){
        $acesso = Acesso::create($request->all());
        Project::find($id)->acessos()->save($acesso);
        return redirect()->back();
    }

    public function store(Request $request){
        $validation = $this->validaProject($request->all());
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
            $data = $request->all();
            $image = $request->file('icon');
            if($image){
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/storage/project/thumbnail');
                $resize_image = Image::make($image->getRealPath());
                $resize_image->resize(50, 50, function($constraint){
                    $constraint->aspectRatio();
                   })->save($destinationPath . '/' . $image_name);

                $destinationPath = public_path('/storage/project');
                $image->move($destinationPath, $image_name);
                $data['icon'] = $image_name;
            }

            $projects = Project::create($data);
            return redirect()
                ->action('ProjectController@index')
                ->with('toast', ['msg' => $projects->name . ' inserido com sucesso!', 'context' => 'success']);
        }
    }

    function validaProject($data)
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
}
