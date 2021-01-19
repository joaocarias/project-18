<?php

namespace App\Dados\Repositorios;

use App\Dados\IRepositorios\IRepositorioEndereco;
use App\Endereco;
use App\Paciente;
use Illuminate\Support\Facades\Auth;

class RepositorioEndereco implements IRepositorioEndereco {
    public function Obter($id){
        return Endereco::Find($id);
    }

    public function ObterTodos(){
        
    }

    public function Adicionar($request){
        $obj = new Endereco();
        $obj->logradouro = $request->input('logradouro');
        $obj->numero = $request->input('numero');   
        $obj->bairro = $request->input('bairro');
        $obj->complemento = $request->input('complemento');
        $obj->cep = $request->input('cep');
        $obj->cidade = $request->input('cidade');
        $obj->uf = $request->input('uf');
                
        $obj->usuario_cadastro = Auth::user()->id;
        $obj->save();

        return $obj->id;
    }

    public function Remover($id){

    }
}