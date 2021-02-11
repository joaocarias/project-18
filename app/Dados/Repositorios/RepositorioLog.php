<?php

namespace App\Dados\Repositorios;
use App\Dados\IRepositorios\IRepositorioLog;
use App\LogSistema;
use Illuminate\Support\Facades\Auth;

class RepositorioLog implements IRepositorioLog
{
    public function Adicionar($tabela, $id, $acao, $stringLog){
        $log = new LogSistema();
        $log->tabela = $tabela;
        $log->tabela_id = $id;
        $log->acao = $acao;
        $log->descricao = $stringLog;
        $log->usuario_id = Auth::user()->id;
        $log->save();
    }
}
