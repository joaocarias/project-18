<?php

namespace App\Dados\Repositorios;

use App\Dados\IRepositorios\IRepositorioProfissional;
use App\Profissional;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RepositorioProfissional implements IRepositorioProfissional {
    public function Obter($id)
    {
        return Profissional::find($id);
    }

    public function ObterTodos(){
        return Profissional::OrderBy('nome', 'asc')->get();
    }

    public function Adicionar($request)
    {
        try{
            
            $obj = new Profissional();
            $obj->nome = mb_strtoupper($request->input('nome'));        
            $obj->cpf = $request->input('cpf');   
            $obj->tipo_profissional_id = $request->input('tipo_profissional_id');          
            $obj->usuario_cadastro = Auth::user()->id;
            $obj->save();
                    
            if(isset($obj->id)){           
                $usuario = new User();
                $usuario->name = $obj->nome;   
                $usuario->username = $obj->cpf;             
                $usuario->email = "email".$obj->id."@email.com";
                $usuario->password = Hash::make($usuario->passwordDefault());            
                $usuario->save();
    
                if($usuario->id){
                    $obj->user_id = $usuario->id;
                    $obj->save();
                }
            }

            return true;
        }catch(Exception $ex){
            //echo $ex;
            return false;
        }
    }

    public function Remover($id)
    {
        
    }
}