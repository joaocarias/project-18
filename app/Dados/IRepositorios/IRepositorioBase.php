<?php

namespace App\Dados\IRepositorios;

interface IRepositorioBase
{
    public function Obter($id);
    public function ObterTodos();
    public function Adicionar($request);
    public function Remover($id);
}