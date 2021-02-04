<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Dados\Repositorios\RepositorioAgenda;
use App\Dados\Repositorios\RepositorioPaciente;
use App\Dados\Repositorios\RepositorioProfissional;
use App\Lib\Auxiliar;
use App\LogSistema;
use App\ViewModel\AgendaViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    private $_repositorioProfissional;
    private $_repositorioAgenda;
    private $_repositorioPaciente;

    public function __construct()
    {
        $this->_repositorioProfissional = new RepositorioProfissional();
        $this->_repositorioAgenda = new RepositorioAgenda();
        $this->_repositorioPaciente = new RepositorioPaciente();
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
        $obj = Agenda::find($id);
      
        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "agendas";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
            
            return redirect()->route('agendas')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }
    }

    public function agendar(Request $request, $pacienteId){    
        $agendasProfissional = null;
        $profissional = null;
        if(isset($request) && !is_null($request)){
            $agendasProfissional = $this->_repositorioAgenda->ObterPorDataProfissional($request->input('profissional_id'), Auxiliar::converterDataParaUSA($request->input('data_agenda')));
            $profissional = $this->_repositorioProfissional->Obter($request->input('profissional_id'));
        }
        
        return view('agenda.agendar', ['paciente' => $this->_repositorioPaciente->obter($pacienteId)              
                                        , 'profissionais' => $this->_repositorioProfissional->ObterTodos()
                                        , 'dataForm' => date("d/m/Y")                          
                                        , 'agendamentos' => $this->_repositorioAgenda->obterAgendasDoPaciente($pacienteId)
                                        , 'agendasProfissional' => $agendasProfissional
                                        , 'pacienteId' => $pacienteId 
                                        , 'profissional' => $profissional ]); 
    }
}
