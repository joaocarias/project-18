<?php

namespace App;

use App\Lib\Auxiliar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function usuarioCadastro()
    {
        return $this->hasOne('App\User', 'id', 'usuario_cadastro');
    }

    public function dataCadastro()
    {         
        return Auxiliar::converterDataTimeBR($this->created_at);
    }

    public function dataAgendamento()
    {         
        return Auxiliar::converterDataTimeBR($this->data_agendamento);
    }

    private function situacao(){
        if(!is_null($this->paciente_id) and $this->paciente_id > 0 ){
            return $this->arraySituacao("AGENDADA", "success") ;
        }
        return $this->arraySituacao("LIBERADA", "primary");
    }

    public function situacaoCor(){
        $situacao = $this->situacao();
        return $situacao['cor'];
    }

    public function situacaoStatus(){
        $situacao = $this->situacao();
        return $situacao['status'];
    }

    private function arraySituacao($status, $cor ){
        return [ 'status' => $status, 'cor' => $cor];
    }


}
