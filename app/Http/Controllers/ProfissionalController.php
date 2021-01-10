<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioProfissional;
use App\Dados\Repositorios\RepositorioTipoProfissional;
use App\LogSistema;
use App\Profissional;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfissionalController extends Controller
{    
    private $_repositorioProfissional;
    private $_repositorioTipoProfissional;

    public function __construct()
    {
        $this->_repositorioProfissional = new RepositorioProfissional();
        $this->_repositorioTipoProfissional = new RepositorioTipoProfissional();    
    }

    public function index()
    {        
        $list = $this->_repositorioProfissional->ObterTodos();
        return view('profissional.index', ['profissionais' => $list]);
    }
    
    public function create()
    {
        $tiposProfissionais = $this->_repositorioTipoProfissional->ObterTodos();
        return view('profissional.create', ['profissional' => null, 'user' => null, 'tiposProfissionais' => $tiposProfissionais]);
    }
    
    public function store(Request $request)
    {
        $request->validate($this->regras(), $this->mensagens());
        $retorno = $this->_repositorioProfissional->Adicionar($request);
        if($retorno)
            return redirect()->route('profissionais')->withStatus(__('Cadastro Realizado com Sucesso!'));
        
        return redirect()->route('profissionais')->withStatus(__('ERROR: Cadastro Não Realizado!'));
    }
    
    public function show($id)
    {
        $obj = Profissional::find($id);
        $usuario = null;
        // $permissoes = null;
        // $regrasDoUser = UserRegra::select('regra_id')->where('user_id', $obj->user_id)->get();
        // $regras = Regra::whereNotIn('id', $regrasDoUser)->get(); 

        if(isset($obj)){
             $usuario = User::find($obj->user_id);
             
            //  if(isset($obj) && isset($obj->user_id) && !is_null($obj->user_id) && $obj->user_id > 0){
            //      $permissoes = UserRegra::join('users', 'user_id', '=', 'users.id')
            //                                  ->join('regras', 'regra_id', '=', 'regras.id')
            //                                  ->where('user_id', $obj->user_id)
            //                                  ->where('users.deleted_at', null)
            //                                  ->where('regras.deleted_at', null)
            //                                  ->get();                                    
            //  }             
        }
        
          return view('profissional.show', ['profissional' => $obj , 'usuario' => $usuario                        
                   //   , 'permissoes' => $permissoes, 'regras' => $regras
                   ]);
    }
    
    public function edit($id)
    {
        $obj = $this->_repositorioProfissional->Obter($id);
        $tiposProfissionais = $this->_repositorioTipoProfissional->ObterTodos();
        return view('profissional.edit', ['profissional' => $obj,  'user' => null, 'tiposProfissionais' => $tiposProfissionais]);
    }
   
    public function update(Request $request, $id)
    {
        $regras = [
            'nome' => 'required|min:3|max:254',
            'cpf' => 'required|min:14|max:20',
            'tipo_profissional_id' => 'required',
        ];
       
        $messagens = [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
            'cpf.required' => 'Campo Obrigatório!',
            'cpf.min' => 'É necessário no mínimo 14 caracteres!',
            'tipo_profissional_id.required' => 'Campo Obrigatório!',          
        ];
       
        $request->validate($regras, $messagens);
        $obj = Profissional::find($id);
        if (isset($obj)) {
            $stringLog = "";
            $atualizarNome = false;
            $atualizarCpf = false;
                         
            if($obj->nome != mb_strtoupper($request->input('nome'))){                
                $stringLog = $stringLog . " - nome: " . mb_strtoupper($obj->nome);
                $obj->nome = mb_strtoupper( $request->input('nome'));
                $atualizarNome = true;
            }

            if($obj->cpf != $request->input('cpf')){                
                $stringLog = $stringLog . " - cpf: " . $obj->cpf;
                $obj->cpf = $request->input('cpf');
                $atualizarCpf = true;
            }

            if($obj->tipo_profissional_id != $request->input('tipo_profissional_id')){                
                $stringLog = $stringLog . " - tipo_profissional_id: " . $obj->tipo_profissional_id;
                $obj->tipo_profissional_id = $request->input('tipo_profissional_id');
            }
            
            $obj->save();
            if($stringLog != ""){
                $log = new LogSistema();
                $log->tabela = "profissional";
                $log->tabela_id = $obj->id;
                $log->acao = "EDICAO";
                $log->descricao = $stringLog;
                $log->usuario_id = Auth::user()->id;
                $log->save();
            }

            if($atualizarCpf || $atualizarNome){
                $usuario = User::find($obj->user_id);
                if(isset($usuario)){
                    $stringLogUsuario = "";
                    
                    if($atualizarNome){
                        $stringLogUsuario = $stringLogUsuario . " - name: " . $usuario->name;
                        $usuario->name = $request->input('nome');                        
                    }

                    if($atualizarCpf){
                        $stringLogUsuario = $stringLogUsuario . " - username: " . $usuario->username;
                        $usuario->username = $request->input('cpf');                      
                    }

                    $usuario->save();
                    if($stringLogUsuario != ""){
                        $log = new LogSistema();
                        $log->tabela = "users";
                        $log->tabela_id = $usuario->id;
                        $log->acao = "EDICAO";
                        $log->descricao = $stringLogUsuario;
                        $log->usuario_id = Auth::user()->id;
                        $log->save();
                    }
                }                
            }

            return redirect()->route('profissionais')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
        return redirect()->route('profissionais')->withStatus(__('Cadastro Não Atualizado!'));
    }
   
    public function destroy($id)
    {
        $obj = Profissional::find($id);
      
        if (isset($obj)) {
            $obj->delete();
            $log = new LogSistema();
            $log->tabela = "profissionals";
            $log->tabela_id = $id;
            $log->acao = "EXCLUSAO";
            $log->descricao = "EXCLUSAO";
            $log->usuario_id = Auth::user()->id;
            $log->save();
            
            $usuario = User::find($obj->user_id);
            if(isset($usuario)){
                $usuario->delete();
                $log = new LogSistema();
                $log->tabela = "users";
                $log->tabela_id = $usuario->id;
                $log->acao = "EXCLUSAO";
                $log->descricao = "EXCLUSAO";
                $log->usuario_id = Auth::user()->id;
                $log->save();                
            }

            return redirect()->route('profissionais')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }

        return redirect()->route('profissionais')->withStatus(__('Cadastro Não Excluído!'));
    }

    public function createUser($id){
        $msg = 'Cadastro não Atualizado!';
        $obj = Profissional::find($id);
        
        if(isset($obj->id)){           
            $usuario = new User();
            $usuario->name = $obj->nome;  
            $usuario->username = $obj->cpf;          
            $usuario->email = "email".$obj->id."@email.com";
            $usuario->password = Hash::make($usuario->passwordDefault());            
            $usuario->save();

            if($usuario->id){
                $obj->user_id = $usuario->id;
                $obj->save();
            }
            $msg = 'Cadastro Atualizado com Sucesso!';
        }

        return redirect()->route('exibir_profissional', ['id' => $id])->withStatus(__($msg));
    }

    public function resetPassword($id){
        $msg = 'Cadastro não Atualizado!';
        $obj = Profissional::find($id);
        if(isset($obj->user_id)){
            $usuario = User::find($obj->user_id);
            $usuario->password = Hash::make($usuario->passwordDefault());
            $usuario->save();

            $log = new LogSistema();
                $log->tabela = "users";
                $log->tabela_id = $usuario->id;
                $log->acao = "EDICAO";
                $log->descricao = "Resete de Senha";
                $log->usuario_id = Auth::user()->id;
                $log->save();

            $msg = 'Cadastro Atualizado com Sucesso!';
        } 

        return redirect()->route('exibir_profissional', ['id' => $id])->withStatus(__($msg));
    }

    private function regras(){
        return [
            'nome' => 'required|min:3|max:254',
            'cpf' => 'required|min:14|max:20',
            'tipo_profissional_id' => 'required',
        ];
    }

    private function mensagens(){
        return [
            'required' => 'Campo Obrigatório!',
            'nome.required' => 'Campo Obrigatório!',
            'nome.min' => 'É necessário no mínimo 3 caracteres!',
            'cpf.required' => 'Campo Obrigatório!',
            'cpf.min' => 'É necessário no mínimo 14 caracteres!',
            'tipo_profissional_id.required' => 'Campo Obrigatório!',          
        ];
    }
}
