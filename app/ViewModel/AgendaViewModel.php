<?php

namespace App\ViewModel;

class AgendaViewModel
{
    private $profissionais;
    private $data;
    private $profissional_id;
    private $profissional_nome;
    private $data_agenda;
    private $agendas;

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

    public function getProfissional_id()
    {
        return $this->profissional_id;
    }

    public function setProfissional_id($profissional_id)
    {
        $this->profissional_id = $profissional_id;

        return $this;
    }

    public function getData_agenda()
    {
        return $this->data_agenda;
    }

    public function setData_agenda($data_agenda)
    {
        $this->data_agenda = $data_agenda;

        return $this;
    }

    public function getAgendas()
    {
        return $this->agendas;
    }

    public function setAgendas($agendas)
    {
        $this->agendas = $agendas;

        return $this;
    }
    
    public function getProfissional_nome()
    {
        return $this->profissional_nome;
    }

    public function setProfissional_nome($profissional_nome)
    {
        $this->profissional_nome = $profissional_nome;

        return $this;
    }
}