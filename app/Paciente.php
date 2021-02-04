<?php

namespace App;

use App\Lib\Auxiliar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
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

    public function dataNascimento()
    {         
        return Auxiliar::converterDataParaBR($this->data_nascimento);
    }

    public function agenda(){
        return $this->hasMany(Agenda::class, 'id', 'paciente_id');
    }
}
