<?php

namespace App\Dados\Repositorios;

use App\Dados\IRepositorios\IRepositorioPaciente;
use App\Lib\Auxiliar;
use App\Paciente;
use Exception;
use Illuminate\Support\Facades\Auth;

class RepositorioPaciente implements IRepositorioPaciente
{
    public function Obter($id)
    {
        return Paciente::find($id);
    }

    public function ObterTodos()
    {
        return Paciente::OrderBy('nome', 'asc')->get();
    }

    public function Adicionar($request)
    {
        try {
            $repositorioEndereco = new RepositorioEndereco();
            $enderecoId = $repositorioEndereco->Adicionar($request);
            if ($enderecoId > 0) {
                $obj = new Paciente();
                $obj->numero_ficha = $request->input('numero_ficha');
                $obj->nome = mb_strtoupper($request->input('nome'));
                $obj->cpf = $request->input('cpf');

                if($this->verificaDataNascimento($request->input('data_nascimento'))){
                    $obj->data_nascimento = Auxiliar::converterDataParaUSA($request->input('data_nascimento')); 
                }         

                $obj->genero = $request->input('genero');
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

    private function verificaDataNascimento($dataNascimento){
        try{
            $data = Auxiliar::converterDataParaUSA($dataNascimento);
            return true;
        }catch(Exception $ex){
            return false;
        } 
    }
}
