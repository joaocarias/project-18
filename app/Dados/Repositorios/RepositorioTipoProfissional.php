<?php

namespace App\Dados\Repositorios;

use App\Dados\IRepositorios\IRepositorioTipoProfissional;
use App\TipoProfissional;
use Illuminate\Support\Facades\Auth;

class RepositorioTipoProfissional implements IRepositorioTipoProfissional{
    public function Obter($id)
    {
        return TipoProfissional::find($id);
    }

    public function ObterTodos(){
        return TipoProfissional::OrderBy('nome', 'asc')->get();
    }

    public function Adicionar($request)
    {
        $obj = new TipoProfissional();
        $obj->nome = mb_strtoupper($request->input('nome'));        
        $obj->usuario_cadastro = Auth::user()->id;
        $obj->save();
    }

    public function Remover($id)
    {
        
    }
}