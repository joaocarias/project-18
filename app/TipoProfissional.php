<?php

namespace App;

use App\Lib\Auxiliar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoProfissional extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function usuarioCadastro()
    {
        return $this->hasOne('App\User', 'id', 'usuario_cadastro');
    }

    public function dataCadastro()
    {         
        return Auxiliar::converterDataParaBR($this->created_at);
    }
}
