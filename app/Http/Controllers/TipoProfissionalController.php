<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioTipoProfissional;
use App\LogSistema;
use App\TipoProfissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoProfissionalController extends Controller
{    
    public function index()
    {
        $repositorio = new RepositorioTipoProfissional;
        $tipos_profissionais = $repositorio->ObterTodos();
        return view('tipo_profissional.index', ['tipos_profissionais' => $tipos_profissionais]);
    }

    public function create()
    {
        return view('tipo_profissional.create', ['tipo_profissional' => null]);
    }

    public function store(Request $request)
    {      
        $request->validate($this->regras(), $this->mensagens());
        $repositorio = new RepositorioTipoProfissional;
        $repositorio->Adicionar($request);        
        return redirect()->route('tipo_profissional')->withStatus(__('Cadastro Realizado com Sucesso!')); 
    }
     
    public function edit($id)
    {
        $repositorio = new RepositorioTipoProfissional();
        $tipoProfissional = $repositorio->Obter($id);
        return view('tipo_profissional.edit', ['tipo_profissional' => $tipoProfissional]);
    }
   
    public function update(Request $request, $id)
    {
        $request->validate($this->regras(), $this->mensagens());
        $obj = TipoProfissional::find($id);
        if (isset($obj)) {
            $stringLog = "";
                         
            if($obj->nome != $request->input('nome')){                
                $stringLog = $stringLog . " - nome: " . $obj->nome;
                $obj->nome =  mb_strtoupper( $request->input('nome'));                
            }
            
            $obj->save();
            if($stringLog != ""){
                $log = new LogSistema();
                $log->tabela = "tipo_profissionals";
                $log->tabela_id = $obj->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }

            return redirect()->route('tipo_profissional')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }

        return redirect()->route('tipo_profissional')->withStatus(__('Cadastro Não Atualizado!'));
    }

    public function destroy($id)
    {
        $obj = TipoProfissional::find($id);
      
        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "tipo_profissionals";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
            
            return redirect()->route('tipo_profissional')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }
    }

    private function regras(){
        return [
            'nome' => 'required|min:3|max:254',
        ];
    }

    private function mensagens(){
        return [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
        ];
    }
}
