<?php

namespace App\Dados\Repositorios;

use App\Dados\IRepositorios\IRepositorioProdutoFornecedor;
use App\Dados\IRepositorios\IRepositorioTipoProfissional;
use App\ProdutoFornecedor;
use App\TipoProfissional;
use Exception;
use Illuminate\Support\Facades\Auth;

class RepositorioProdutoFornecedor implements IRepositorioProdutoFornecedor{
    public function Obter($id)
    {
        return ProdutoFornecedor::find($id);
    }

    public function ObterTodos(){
        return ProdutoFornecedor::OrderBy('nome', 'asc')->get();
    }

    public function Adicionar($request)
    {
        try {
            $obj = new ProdutoFornecedor();
            $obj->nome = mb_strtoupper($request->input('produto_fonecedor_nome'));        
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