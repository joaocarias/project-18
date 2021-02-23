<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dados\Repositorios\RepositorioLog;
use App\Dados\Repositorios\RepositorioProduto;
    
class ProdutoController extends Controller
{
    private $_repositorioProduto;
    private $_repositorioLog;

    public function __construct()
    {
        $this->_repositorioProduto = new RepositorioProduto();
        $this->_repositorioLog = new RepositorioLog();
    }

    public function index()
    {
        $list = $this->_repositorioProduto->ObterTodos();
        return view('produto.index', ['produtos' => $list]);
    }

    public function store(Request $request)
    {
        $request->validate($this->regras(), $this->mensagens());
        
        if ($this->_repositorioProduto->Adicionar($request))
            return redirect()->route('produtos')->withStatus(__('Cadastro realizado com Sucesso!'));

        return redirect()->route('produtos')->withStatus(__('ERROR: Cadastro Não Realizado!'));
    }

    public function update(Request $request)
    {
        $request->validate($this->regras(), $this->mensagens());
        $obj = $this->_repositorioProduto->Obter($request->input('produto_id'));
        if (isset($obj)) {
            $stringLog = "";

            if ($obj->nome != mb_strtoupper($request->input('produto_nome'))) {
                $stringLog = $stringLog . " - nome: " . mb_strtoupper($obj->nome);
                $obj->nome = mb_strtoupper($request->input('produto_nome'));
            }

            if ($obj->precoBR() != $request->input('valor_base')) {
                $stringLog = $stringLog . " - valor_base: " . $obj->valor_base;
                $obj->definirPrecoUS($request->input('valor_base'));
            }

            $obj->save();

            if ($stringLog != "") {
                $this->_repositorioLog->Adicionar('produtos', $obj->id, 'EDICAO', $stringLog);
            }

            return redirect()->route('produtos')->withStatus(__('Cadastro atualizado com Sucesso!'));
        }

        return redirect()->route('produtos')->withStatus(__('ERROR: Cadastro Não atualizado!'));
    }

    public function destroy($id)
    {
        $obj = $this->_repositorioProduto->Obter($id);
        
        if (isset($obj)) {
            $this->_repositorioLog->Adicionar('protudos', $obj->id, 'EXCLUSAO', 'EXCLUSAO');
            $obj->delete();

            return redirect()->route('produtos')->withStatus(__('Cadastro Excluído com Sucesso!'));
        }

        return redirect()->route('produtos')->withStatus(__('Cadastro Não Excluído!'));
    }

    private function regras()
    {
        return [
            'produto_nome' => 'required|min:1|max:254',
        ];
    }

    private function mensagens()
    {
        return [
            'required' => 'Campo Obrigatório!',
            'produto_nome.required' => 'Campo Obrigatório!',
            'produto_nome.min' => 'É necessário no mínimo 3 caracteres!',
        ];
    }
}
