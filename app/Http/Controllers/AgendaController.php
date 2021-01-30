<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioAgenda;
use App\Dados\Repositorios\RepositorioProfissional;
use App\Lib\Auxiliar;
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
        $agendas = array(); 
        if(isset($data_agenda) && isset($profissional_id) && !is_null($profissional_id) && $profissional_id > 0)
        {
            $viewModel->setData_agenda($data_agenda);
            $viewModel->setProfissional_id($profissional_id);

            $agendas = $this->_repositorioAgenda->ObterPorDataProfissional($profissional_id, Auxiliar::converterDataParaUSA($data_agenda));
            $viewModel->setProfissional_nome(($this->_repositorioProfissional->Obter($profissional_id))->nome);
        }else{
            $viewModel->setData_agenda(date("d/m/Y"));
        }

        return view('agenda.index', ['model' => $viewModel, 'agendas' => $agendas] );
    }

    public function store(Request $request)
    {
        if($this->_repositorioAgenda->Adicionar($request))
            return redirect()->route('agendas', ['profissional_id' => $request->input('liberar_profissional_id'), 'data_agenda' => $request->input('hidden_liberar_data_agenda')])->withStatus(__('Cadastro Realizado com Sucesso!'));
        
        return redirect()->route('agendas', ['profissional_id' => $request->input('liberar_profissional_id'), 'data_agenda' => $request->input('hidden_liberar_data_agenda')])->withStatus(__('ERROR: Cadastro Não Realizado!'));
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
