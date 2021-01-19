<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioEndereco;
use App\Dados\Repositorios\RepositorioPaciente;
use Illuminate\Http\Request;

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
        
    }
   
    public function update(Request $request, $id)
    {
        
    }
   
    public function destroy($id)
    {
        
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
