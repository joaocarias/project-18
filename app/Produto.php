<?php

namespace App;

use App\Lib\Auxiliar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function converterMoedaParaUS($valor){
        $str = str_replace('.', '', $valor); 
        return str_replace(',', '.', $str);        
    }

    public function definirPrecoUS($valor){
        $str = str_replace('.', '', $valor); 
        $this->valor_base = str_replace(',', '.', $str);        
    }

    public function precoBR(){         
        return number_format($this->valor_base, 2, ',', '.');
    }
    
    public function usuarioCadastro()
    {
        return $this->hasOne('App\User', 'id', 'usuario_cadastro');
    }

    public function dataCadastro()
    {
        return Auxiliar::converterDataTimeBR($this->created_at);
    }
}
