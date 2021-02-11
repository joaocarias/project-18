<?php

namespace App\Http\Controllers;

use App\Dados\Repositorios\RepositorioFornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{ 
    private $_repositorioFornecedor;
    
    public function __construct()
    {
        $this->_repositorioFornecedor = new RepositorioFornecedor();
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
