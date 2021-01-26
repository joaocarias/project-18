<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioProfissional;
use App\ViewModel\AgendaViewModel;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    private $_repositorioProfissional;

    public function __construct()
    {
        $this->_repositorioProfissional = new RepositorioProfissional();
    } 

    public function index()
    {
        $viewModel = new AgendaViewModel();
        $viewModel->setProfissionais($this->_repositorioProfissional->ObterTodos());

        return view('agenda.index', ['agendas' => $viewModel]);
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
