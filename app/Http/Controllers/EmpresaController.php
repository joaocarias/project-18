<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Endereco;
use App\LogSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = Empresa::First();
        if(isset($obj)){
            $endereco = Endereco::Find($obj->endereco_id);
            return view('empresa.index', ['empresa' => $obj, 'endereco' => $endereco]);
        }
        return view('empresa.index', ['empresa' => $obj]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obj = Empresa::find($id);
        if (isset($obj)) {            
            $endereco = Endereco::Find($obj->endereco_id);            
        } 

        return view('empresa.edit', ['empresa' => $obj, 'endereco' => $endereco]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        
        $request->validate($this->ObterRegras(), $this->ObterMensagens());

        $empresa = Empresa::find($id);
        if (isset($empresa)) {            
            $stringLog = "";
            
            if($empresa->nome != $request->input('nome')){
                $stringLog = $stringLog . " - nome: " . $empresa->nome;
                $empresa->nome = $request->input('nome');                
            }
                                  
            if($empresa->email != $request->input('email')){
                $stringLog = $stringLog . " - email: " . $empresa->email;
                $empresa->email = $request->input('email');
            }

            if($empresa->telefone != $request->input('telefone')){
                $stringLog = $stringLog . " - telefone: " . $empresa->telefone;
                $empresa->telefone = $request->input('telefone');
            }
                       
            $empresa->save();
            
            if($stringLog != ""){
                $log = new LogSistema();
                $log->tabela = "empresas";
                $log->tabela_id = $empresa->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }

            $endereco = Endereco::Find($empresa->endereco_id);
            if (isset($endereco)) {                
                $stringLog = "";

                if($endereco->cep != $request->input('cep')){
                    $stringLog = $stringLog . " - cep: " . $endereco->cep;
                    $endereco->cep = $request->input('cep');
                }

                if($endereco->logradouro != $request->input('logradouro')){
                    $stringLog = $stringLog . " - logradouro: " . $endereco->logradouro;
                    $endereco->logradouro = $request->input('logradouro');
                }

                if($endereco->numero != $request->input('numero')){
                    $stringLog = $stringLog . " - numero: " . $endereco->numero;
                    $endereco->numero = $request->input('numero');
                }

                if($endereco->bairro != $request->input('bairro')){
                    $stringLog = $stringLog . " - bairro: " . $endereco->bairro;
                    $endereco->bairro = $request->input('bairro');
                }

                if($endereco->complemento != $request->input('complemento')){
                    $stringLog = $stringLog . " - complemento: " . $endereco->complemento;
                    $endereco->complemento = $request->input('complemento');
                }

                if($endereco->cidade != $request->input('cidade')){
                    $stringLog = $stringLog . " - cidade: " . $endereco->cidade;
                    $endereco->cidade = $request->input('cidade');
                }

                if($endereco->uf != $request->input('uf')){
                    $stringLog = $stringLog . " - uf: " . $endereco->uf;
                    $endereco->uf = $request->input('uf');
                }

                $endereco->save();
                
                if($stringLog != ""){
                    $log = new LogSistema();
                    $log->tabela = "enderecos";
                    $log->tabela_id = $endereco->id;
                    $log->acao = "EDICAO";
                    $log->descricao = $stringLog;
                    $log->usuario_id = Auth::user()->id;
                    $log->save();
                }

                return view('empresa.index', ['empresa' => $empresa, 'endereco' => $endereco]);
            }
        }
    }    

    private function ObterRegras(){
        return [
            'nome' => 'required|min:3|max:254',
            
            'logradouro' => 'required|min:3|max:254',
            'cidade' => 'required|min:3|max:254',
            'uf' => 'required',
        ];       
    }

    private function ObterMensagens(){
        return [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
            
            'logradouro.required' => 'Campo Obrigatório!',
            'logradouro.min' => 'É necessário no mínimo 3 caracteres!',
            'cidade.required' => 'Campo Obrigatório!',
            'cidade.min' => 'É necessário no mínimo 3 caracteres!',
            'uf.required' => 'Campo Obrigatório!',
        ];
    }

}
