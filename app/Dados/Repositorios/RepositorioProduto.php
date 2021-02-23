<?php

namespace App\Dados\Repositorios;

use App\Dados\IRepositorios\IRepositorioProduto;
use App\Produto;
use Exception;
use Illuminate\Support\Facades\Auth;

class RepositorioProduto implements IRepositorioProduto{
    public function Obter($id)
    {
        return Produto::find($id);
    }

    public function ObterTodos(){
        return Produto::OrderBy('nome', 'asc')->get();
    }

    public function Adicionar($request)
    {
        try {
            $obj = new Produto();
            $obj->nome = mb_strtoupper($request->input('produto_nome')); 
            $obj->definirPrecoUS($request->input('valor_base')) ;
            $obj->usuario_cadastro = Auth::user()->id;
            $obj->save();
            return true;
        } catch (Exception $ex) {
            //echo $ex;
            return false;
        }
    }

    public function Remover($id)
    {
        
    }
}