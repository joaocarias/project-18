<?php

namespace App\Dados\Repositorios;

use App\Agenda;
use App\Dados\IRepositorios\IRepositorioAgenda;
use App\Lib\Auxiliar;
use App\Paciente;
use App\ViewModel\AgendaViewModel;
use Exception;
use Illuminate\Support\Facades\Auth;

class RepositorioAgenda implements IRepositorioAgenda
{
    public function Obter($id)
    {
        return Agenda::find($id);
    }

    public function ObterTodos()
    {
    }

    public function Adicionar($request)
    {
        try {
            $obj = new Agenda();
            $obj->profissional_id = $request->input('liberar_profissional_id');
            $obj->data_agendamento = Auxiliar::converterDataParaUSA($request->input("hidden_liberar_data_agenda")) . " " .$request->input("liberar_horario_agenda") . ":00";
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

    public function ObterPorDataProfissional($profissional_id, $data)
    {
        return Agenda::where('profissional_id', $profissional_id)
                        ->whereBetween('data_agendamento', [$data . " 00:00:00", $data . " 23:59:59" ])
                        ->OrderBy('data_agendamento', 'asc')->get();
    }

    public function obterAgendasDoPaciente($pacienteId){
        return Agenda::where('paciente_id', $pacienteId)
                        ->OrderBy('data_agendamento', 'asc')->get();;
    }
}
