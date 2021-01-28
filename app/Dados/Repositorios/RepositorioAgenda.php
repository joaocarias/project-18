<?php

namespace App\Dados\Repositorios;

use App\Agenda;
use App\Dados\IRepositorios\IRepositorioAgenda;

class RepositorioAgenda implements IRepositorioAgenda{
    public function Obter($id)
    {
        return Agenda::find($id);
    }

    public function ObterTodos(){
        
    }

    public function Adicionar($request)
    {
        
    }

    public function Remover($id)
    {
        
    }

    public function ObterPorDataProfissional($profissional_id, $data){
        return Agenda::OrderBy('data_agendamento', 'asc')->get();
    }
}