<?php

namespace App\Dados\IRepositorios;

interface IRepositorioLog {
    public function Adicionar($tabela, $id, $acao, $stringLog);
}
