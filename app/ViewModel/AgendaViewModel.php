<?php

namespace App\ViewModel;

class AgendaViewModel
{
    private $profissionais;
    private $data;

    public function __construct()
    {
        
    }
    
    public function getProfissionais()
    {
        return $this->profissionais;
    }
    
    public function setProfissionais($profissionais)
    {
        $this->profissionais = $profissionais;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}