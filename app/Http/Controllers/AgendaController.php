<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioAgenda;
use App\Dados\Repositorios\RepositorioProfissional;
use App\ViewModel\AgendaViewModel;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    private $_repositorioProfissional;
    private $_repositorioAgenda;

    public function __construct()
    {
        $this->_repositorioProfissional = new RepositorioProfissional();
        $this->_repositorioAgenda = new RepositorioAgenda();
    } 

    public function index(Request $request)
    {
        $viewModel = new AgendaViewModel();
        $viewModel->setProfissionais($this->_repositorioProfissional->ObterTodos());
        
        $data_agenda = $request->input('data_agenda');
        $profissional_id = $request->input('profissional_id'); 
        if(isset($data_agenda) && isset($profissional_id) && !is_null($profissional_id) && $profissional_id > 0)
        {
            $viewModel->setData_agenda($data_agenda);
            $viewModel->setProfissional_id($profissional_id);

            $viewModel->setAgendas($this->_repositorioAgenda->ObterPorDataProfissional($profissional_id, $data_agenda));
            $viewModel->setProfissional(($this->_repositorioProfissional->Obter($profissional_id)));
        }else{
            $viewModel->setData_agenda(date("d/m/Y"));
        }

        return view('agenda.index', ['model' => $viewModel]);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
