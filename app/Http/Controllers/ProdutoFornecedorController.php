<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioFornecedor;
use App\Dados\Repositorios\RepositorioProdutoFornecedor;
use App\Fornecedor;
use Illuminate\Http\Request;

class ProdutoFornecedorController extends Controller
{
    private $_repositorioProdutoFornecedor;
 
    public function __construct()
    {
        $this->_repositorioProdutoFornecedor = new RepositorioProdutoFornecedor();  
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
                ['id' =>$fornecedorId]
            )->withStatus(__('ERROR: Cadastro Não Realizado!'));     
    }

    public function update(Request $request, $id)
    {
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
