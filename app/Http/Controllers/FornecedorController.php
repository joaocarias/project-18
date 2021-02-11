<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioFornecedor;
use App\Dados\Repositorios\RepositorioEndereco;
use App\Dados\Repositorios\RepositorioLog;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    private $_repositorioFornecedor;
    private $_repositorioEndereco;
    private $_repositorioLog;

    public function __construct()
    {
        $this->_repositorioFornecedor = new RepositorioFornecedor();
        $this->_repositorioEndereco = new RepositorioEndereco();
        $this->_repositorioLog = new RepositorioLog();
    }

    public function index()
    {
        $objs = $this->_repositorioFornecedor->ObterTodos();
        return view('fornecedor.index', ['fornecedores' => $objs]);
    }

    public function create()
    {
        return view('fornecedor.create', ['fornecedor' => null]);
    }

    public function store(Request $request)
    {
        $request->validate($this->regras(), $this->mensagens());
        $retorno = $this->_repositorioFornecedor->Adicionar($request);
        if($retorno)
            return redirect()->route('fornecedores')->withStatus(__('Cadastro Realizado com Sucesso!'));

        return redirect()->route('fornecedores')->withStatus(__('ERROR: Cadastro Não Realizado!'));
    }

    public function show($id)
    {
        $endereco = null;
        $obj = $this->_repositorioFornecedor->obter($id);

        if($obj->endereco_id > 0)
            $endereco = $this->_repositorioEndereco->obter($obj->endereco_id);

        return view('fornecedor.show', ['fornecedor' => $obj
                                        , 'endereco' => $endereco
                    ]);
    }

    public function edit($id)
    {
        $endereco = null;
        $obj = $this->_repositorioFornecedor->obter($id);

        if($obj->endereco_id > 0)
            $endereco = $this->_repositorioEndereco->obter($obj->endereco_id);

        return view('fornecedor.edit', ['fornecedor' => $obj, 'endereco' => $endereco]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->regras(), $this->mensagens());
        $obj = $this->_repositorioFornecedor->Obter($id);
        if (isset($obj)) {
            $stringLog = "";

            if($obj->nome != mb_strtoupper($request->input('nome'))){
                $stringLog = $stringLog . " - nome: " . mb_strtoupper($obj->nome);
                $obj->nome = mb_strtoupper( $request->input('nome'));
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
                $this->_repositorioLog->Adicionar('fornecedores', $obj->id, 'EDICAO', $stringLog);
            }

            $endereco = $this->_repositorioEndereco->Obter($obj->endereco_id);
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
                    $this->_repositorioLog->Adicionar('enderecos', $endereco->id, 'EDICAO', $stringLog);
                }
            }
            return redirect()->route('fornecedores')->withStatus(__('Cadastro Atualizado com Sucesso!'));
        }
        return redirect()->route('fornecedores')->withStatus(__('Cadastro Não Atualizado!'));
    }

    public function destroy($id)
    {
        $obj = $this->_repositorioFornecedor->Obter($id);

        if (isset($obj)) {
            $this->_repositorioLog->Adicionar('fornecedores', $obj->id, 'EXCLUSAO', 'EXCLUSAO');
            $obj->delete();

            $endereco = $this->_repositorioEndereco->Obter($obj->endereco_id);
            if(isset($endereco)){
                $this->_repositorioLog->Adicionar('enderecos', $endereco->id, 'EXCLUSAO', 'EXCLUSAO');
                $endereco->delete();
            }

            return redirect()->route('fornecedores')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }
        return redirect()->route('fornecedores')->withStatus(__('Cadastro Não Excluído!'));
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
