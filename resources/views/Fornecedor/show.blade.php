@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">

        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fornecedores') }}">Fornecedores</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            @if (session('status'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if(isset($fornecedor) && ($fornecedor->id > 0) )

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Detalhes') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Nome: <strong>{{ __($fornecedor->nome)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            Telefone: <strong> {{ __($fornecedor->telefone)  }}
                            </strong>
                        </div>

                        <div class="col-md-3">
                            E-mail: <strong> {{ __($fornecedor->email)  }}
                            </strong>
                        </div>
                    </div>

                    @if(isset($endereco) && ($endereco->id > 0) )

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            Endereço:
                            <strong>
                                {{ __($endereco->logradouro) }}
                                {{ __(', ' . $endereco->numero) }}
                                {{ __(', ' . $endereco->complemento) }}
                                {{ __(' - ' . $endereco->bairro) }}
                                {{ __(' - ' . $endereco->cidade) }}
                                {{ __(' - ' . $endereco->uf) }}
                            </strong>
                        </div>
                    </div>

                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('editar_fornecedor', ['id' => $fornecedor->id ]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar </a>
                            <a href="#" class="btn btn-danger btn-sm btn-excluir" id-fornecedor="{{ $fornecedor->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Produtos') }}</div>
                <div class="card-body">
                    @if(isset($fornecedor->produtos) && count($fornecedor->produtos) > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Valor Base</th>
                                <th scope="col">Criado Por</th>
                                <th scope="col">Data de Criação</th>
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($fornecedor->produtos as $item)
                            <tr>
                                <td scope="row">{{ __($item->id) }}</td>
                                <td>{{ __($item->nome) }}</td>
                                <td>{{ __($item->precoBR()) }}</td>
                                <td>{{ __($item->usuarioCadastro->name) }}</td>
                                <td>{{ __($item->dataCadastro()) }}</td>
                                <td class="text-right">
                                    <a href="#" class="btn btn-primary btn-sm btn-editar-produto-fornecedor" obj-id-produto-fornecedor="{{ $item->id }}" obj-id-fornecedor="{{ $item->fornecedor_id }}" obj-nome-produto-fornecedor="{{ $item->nome }}" obj-valor-produto-fornecedor="{{ $item->precoBR() }}" ><i class="far fa-edit"></i> Editar </a>
                                    <a href="#" class="btn btn-danger btn-sm btn-excluir-produto-fornecedor" obj-id-produto-fornecedor="{{ $item->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Não encontrou registros!</p>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" class="btn btn-dark btn-sm btn-inserir-produto-fornecedor"> <i class="far fa-edit"></i> Inserir Produto </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

</div>

@include('layouts._modal_excluir')
@include('produto_fornecedor._modal_novo')
@include('produto_fornecedor._modal_editar')
@include('produto_fornecedor._modal_excluir')

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function($) {
        $('.mask_moeda_real').mask("#.##0,00", {
            reverse: true
        });
    });

    $('.btn-excluir').on('click', function() {
        var id = $(this).attr('id-fornecedor');
        $('#url-modal-excluir').attr('href', '/fornecedores/excluir/' + id);
        $('#ModalExcluir').modal('show');
    });

    $('.btn-inserir-produto-fornecedor').on('click', function() {
        $('#ModalInserirProdutoFornecedor').modal('show');
    });

    $('.url-modal-submit-form-produto-fornecedor').on('click', function() {
        $('.form-inserir-produto-fornecedor').submit();
    });

    $('.btn-editar-produto-fornecedor').on('click', function() {
        var id = $(this).attr('obj-id-produto-fornecedor');
        var fornecedor_id = $(this).attr('obj-fornecedor-id');
        var nome = $(this).attr('obj-nome-produto-fornecedor');
        var preco = $(this).attr('obj-valor-produto-fornecedor');

        $('.fornecedor_id').val(fornecedor_id);
        $('.produto_fornecedor_id').val(id);
        $('.produto_fonecedor_nome').val(nome);
        $('.valor_base').val(preco);

        $('#ModalEditarProdutoFornecedor').modal('show');       
    });

    $('.url-modal-submit-form-editar-produto-fornecedor').on('click', function() {
        $('.form-editar-produto-fornecedor').submit();
    });

    $('.btn-excluir-produto-fornecedor').on('click', function() {
        var id = $(this).attr('obj-id-produto-fornecedor');
        $('#url-modal-excluir-produto-fornecedor').attr('href', '/produtofornecedor/excluir/' + id);
        $('#ModalExcluirProdutoFornecedor').modal('show');
    });
</script>
@endsection