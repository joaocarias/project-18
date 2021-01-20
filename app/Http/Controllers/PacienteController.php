<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioEndereco;
use App\Dados\Repositorios\RepositorioPaciente;
use App\Endereco;
use App\Lib\Auxiliar;
use App\LogSistema;
use App\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{   
    private $_repositorioPaciente;

    public function __construct()
    {
        $this->_repositorioPaciente = new RepositorioPaciente();   
        $this->_repositorioEndereco = new RepositorioEndereco(); 
    }

    public function index()
    {
        $pacientes = $this->_repositorioPaciente->ObterTodos();
        return view('paciente.index', ['pacientes' => $pacientes]);
    }
    
    public function create()
    {
        return view('paciente.create', ['paciente' => null]);
    }

    public function store(Request $request)
    {
        $request->validate($this->regras(), $this->mensagens());
        $retorno = $this->_repositorioPaciente->Adicionar($request);
        if($retorno)
            return redirect()->route('pacientes')->withStatus(__('Cadastro Realizado com Sucesso!'));
        
        return redirect()->route('pacientes')->withStatus(__('ERROR: Cadastro Não Realizado!'));
    }

    public function show($id)
    {
        $endereco = null;
        $obj = $this->_repositorioPaciente->obter($id);        
              
        if($obj->endereco_id > 0)
            $endereco = $this->_repositorioEndereco->obter($obj->endereco_id);
     
        return view('paciente.show', ['paciente' => $obj, 'endereco' => $endereco]);
    }
    
    public function edit($id)
    {
        $endereco = null;
        $obj = $this->_repositorioPaciente->obter($id);  
             
        if($obj->endereco_id > 0)
            $endereco = $this->_repositorioEndereco->obter($obj->endereco_id);

        $obj->data_nascimento = $obj->dataNascimento();
     
        return view('paciente.edit', ['paciente' => $obj, 'endereco' => $endereco]);
    }
   
    public function update(Request $request, $id)
    {
        $request->validate($this->regras(), $this->mensagens());
        $obj = $this->_repositorioPaciente->Obter($id);
        if (isset($obj)) {
            $stringLog = "";
            
            if($obj->nome != mb_strtoupper($request->input('nome'))){                
                $stringLog = $stringLog . " - nome: " . mb_strtoupper($obj->nome);
                $obj->nome = mb_strtoupper( $request->input('nome'));               
            }

            if($obj->cpf != $request->input('cpf')){                
                $stringLog = $stringLog . " - cpf: " . $obj->cpf;
                $obj->cpf = $request->input('cpf');
            }

            if($obj->numero_ficha != $request->input('numero_ficha')){
                $stringLog = $stringLog . " - numero_ficha: " . $obj->numero_ficha;
                $obj->numero_ficha = $request->input('numero_ficha');                
            }
            
            if($obj->data_nascimento != Auxiliar::converterDataParaUSA($request->input('data_nascimento'))){
                $stringLog = $stringLog . " - data_nascimento: " . $obj->data_nascimento;
                $obj->data_nascimento = Auxiliar::converterDataParaUSA($request->input('data_nascimento'));                
            }

            if($obj->genero != $request->input('genero')){
                $stringLog = $stringLog . " - genero: " . $obj->genero;
                $obj->genero = $request->input('genero');                
            }
            
            if($obj->email != $request->input('email')){
                $stringLog = $stringLog . " - email: " . $obj->email;
                $obj->email = $request->input('email');
            }

            if($obj->telefone != $request->input('telefone')){
                $stringLog = $stringLog . " - telefone: " . $obj->telefone;
                $obj->telefone = $request->input('telefone');
            }
                       
            $obj->save();
            
            if($stringLog != ""){
                $log = new LogSistema();
                $log->tabela = "paciente";
                $log->tabela_id = $obj->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }

            $endereco = Endereco::Find($obj->endereco_id);
            if (isset($endereco)) {                
                $stringLog = "";

                if($endereco->cep != $request->input('cep')){
                    $stringLog = $stringLog . " - cep: " . $endereco->cep;
                    $endereco->cep = $request->input('cep');
                }

                if($endereco->logradouro != $request->input('logradouro')){
                    $stringLog = $stringLog . " - logradouro: " . $endereco->logradouro;
                    $endereco->logradouro = $request->input('logradouro');
                }

                if($endereco->numero != $request->input('numero')){
                    $stringLog = $stringLog . " - numero: " . $endereco->numero;
                    $endereco->numero = $request->input('numero');
                }

                if($endereco->bairro != $request->input('bairro')){
                    $stringLog = $stringLog . " - bairro: " . $endereco->bairro;
                    $endereco->bairro = $request->input('bairro');
                }

                if($endereco->complemento != $request->input('complemento')){
                    $stringLog = $stringLog . " - complemento: " . $endereco->complemento;
                    $endereco->complemento = $request->input('complemento');
                }

                if($endereco->cidade != $request->input('cidade')){
                    $stringLog = $stringLog . " - cidade: " . $endereco->cidade;
                    $endereco->cidade = $request->input('cidade');
                }

                if($endereco->uf != $request->input('uf')){
                    $stringLog = $stringLog . " - uf: " . $endereco->uf;
                    $endereco->uf = $request->input('uf');
                }

                $endereco->save();
                
                if($stringLog != ""){
                    $log = new LogSistema();
                    $log->tabela = "enderecos";
                    $log->tabela_id = $endereco->id;
                    $log->acao = "EDICAO";
                    $log->descricao = $stringLog;
                    $log->usuario_id = Auth::user()->id;
                    $log->save();
                }
            }
            return redirect()->route('pacientes')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
        return redirect()->route('pacientes')->withStatus(__('Cadastro Não Atualizado!'));
       
    }
   
    public function destroy($id)
    {
        $obj = Paciente::find($id);
      
        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "pacientes";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
            
            $endereco = Endereco::find($obj->endereco_id);
            if(isset($endereco)){
                $endereco->delete();
                $log = new LogSistema();
                $log->tabela = "enderecos";
                $log->tabela_id = $endereco->id;
                $log->acao = "EXCLUSAO";
                $log->descricao = "EXCLUSAO";
                $log->usuario_id = Auth::user()->id;
                $log->save();                
            }

            return redirect()->route('pacientes')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }
        return redirect()->route('pacientes')->withStatus(__('Cadastro Não Excluído!'));
    }

    private function regras(){
        return [
            'nome' => 'required|min:3|max:254',
            
            'logradouro' => 'required|min:3|max:254',
            'cidade' => 'required|min:3|max:254',
            'uf' => 'required',
        ]; 
    }

    private function mensagens(){
        return [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
            
            'logradouro.required' => 'Campo Obrigatório!',
            'logradouro.min' => 'É necessário no mínimo 3 caracteres!',
            'cidade.required' => 'Campo Obrigatório!',
            'cidade.min' => 'É necessário no mínimo 3 caracteres!',
            'uf.required' => 'Campo Obrigatório!',
        ];
    }
}
