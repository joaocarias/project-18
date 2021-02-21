<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioLog;
use App\Dados\Repositorios\RepositorioProdutoFornecedor;
use Illuminate\Http\Request;


class ProdutoFornecedorController extends Controller
{
    private $_repositorioProdutoFornecedor;
    private $_repositorioLog;

    public function __construct()
    {
        $this->_repositorioProdutoFornecedor = new RepositorioProdutoFornecedor();
        $this->_repositorioLog = new RepositorioLog();
    }

    public function store(Request $request)
    {
        $request->validate($this->regras(), $this->mensagens());
        $fornecedorId = $request->input('fornecedor_id');

        if ($this->_repositorioProdutoFornecedor->Adicionar($request))
            return redirect()->action(
                [FornecedorController::class, 'show'],
                ['id' => $fornecedorId]
            )->withStatus(__('Cadastro realizado com Sucesso!'));

        return redirect()->action(
            [FornecedorController::class, 'show'],
            ['id' => $fornecedorId]
        )->withStatus(__('ERROR: Cadastro Não Realizado!'));
    }

    public function update(Request $request)
    {
        $request->validate($this->regras(), $this->mensagens());
        $obj = $this->_repositorioProdutoFornecedor->Obter($request->input('produto_fornecedor_id'));
        if (isset($obj)) {
            $stringLog = "";

            if ($obj->nome != mb_strtoupper($request->input('produto_fonecedor_nome'))) {
                $stringLog = $stringLog . " - nome: " . mb_strtoupper($obj->nome);
                $obj->nome = mb_strtoupper($request->input('produto_fonecedor_nome'));
            }

            if ($obj->precoBR() != $request->input('valor_base')) {
                $stringLog = $stringLog . " - valor_base: " . $obj->valor_base;
                $obj->definirPrecoUS($request->input('valor_base'));
            }

            $obj->save();

            if ($stringLog != "") {
                $this->_repositorioLog->Adicionar('produto_fornecedors', $obj->id, 'EDICAO', $stringLog);
            }

            return redirect()->action(
                [FornecedorController::class, 'show'],
                ['id' => $obj->fornecedor_id ]
            )->withStatus(__('Cadastro realizado com Sucesso!'));
        }

        return redirect()->action(
            [FornecedorController::class, 'show'],
            ['id' => $request->input('fornecedor_id')]
        )->withStatus(__('ERROR: Cadastro Não Realizado!'));
    }

    public function destroy($id)
    {
    }

    private function regras()
    {
        return [
            'produto_fonecedor_nome' => 'required|min:1|max:254',
        ];
    }

    private function mensagens()
    {
        return [
            'required' => 'Campo Obrigatório!',
            'produto_fonecedor_nome.required' => 'Campo Obrigatório!',
            'produto_fonecedor_nome.min' => 'É necessário no mínimo 3 caracteres!',
        ];
    }
}
