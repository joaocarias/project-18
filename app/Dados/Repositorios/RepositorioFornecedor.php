<?php

namespace App\Dados\Repositorios;

use App\Dados\IRepositorios\IRepositorioFornecedor;
use App\Fornecedor;
use App\Lib\Auxiliar;
use App\Paciente;
use Exception;
use Illuminate\Support\Facades\Auth;

class RepositorioFornecedor implements IRepositorioFornecedor
{
    public function Obter($id)
    {
        return Fornecedor::find($id);
    }

    public function ObterTodos()
    {
        return Fornecedor::OrderBy('nome', 'asc')->get();
    }

    public function Adicionar($request)
    {
        try {
            $repositorioEndereco = new RepositorioEndereco();
            $enderecoId = $repositorioEndereco->Adicionar($request);
            if ($enderecoId > 0) {
                $obj = new Fornecedor();
                $obj->nome = mb_strtoupper($request->input('nome'));
                
                $obj->telefone = $request->input('telefone');
                $obj->email = $request->input('email');

                $obj->endereco_id = $enderecoId;
                $obj->usuario_cadastro = Auth::user()->id;
                $obj->save();

                return true;
            }
            return false;
        } catch (Exception $ex) {
            echo $ex;
            return false;
        }
    }

    public function Remover($id)
    {

    }  
}
