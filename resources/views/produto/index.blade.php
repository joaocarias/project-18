@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Produtos</li>
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

            <div class="row">
                <div class="col-md-12">
                    <a href="#" class="btn btn-primary btn-sm btn-inserir-produto">
                        <i class="far fa-file-alt"></i> &nbsp;
                        Cadastrar
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Produtos') }}</div>
                <div class="card-body">
                    @if(isset($produtos) && count($produtos) > 0)
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
                            @foreach ($produtos as $item)
                            <tr>
                                <td scope="row">{{ __($item->id) }}</td>
                                <td>{{ __($item->nome) }}</td>
                                <td>{{ __($item->precoBR()) }}</td>
                                <td>{{ __($item->usuarioCadastro->name) }}</td>
                                <td>{{ __($item->dataCadastro()) }}</td>
                                <td class="text-right">
                                    <a href="#" class="btn btn-primary btn-sm btn-editar-produto" obj-id-produto="{{ $item->id }}" obj-nome-produto="{{ $item->nome }}" obj-valor-produto="{{ $item->precoBR() }}" ><i class="far fa-edit"></i> Editar </a>
                                    <a href="#" class="btn btn-danger btn-sm btn-excluir-produto" obj-id-produto="{{ $item->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Não encontrou registros!</p>
                    @endif
                
                </div>
            </div>
        </div>
    </div>

@include('produto._modal_novo')
@include('produto._modal_editar')
@include('produto._modal_excluir')

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function($) {
        $('.mask_moeda_real').mask("#.##0,00", {
            reverse: true
        });
    });

    $('.btn-inserir-produto').on('click', function() {
        $('#ModalInserirProduto').modal('show');
    });

    $('.url-modal-submit-form-produto').on('click', function() {
        $('.form-inserir-produto').submit();
    });

    $('.btn-editar-produto').on('click', function() {
        var id = $(this).attr('obj-id-produto');
        var nome = $(this).attr('obj-nome-produto');
        var preco = $(this).attr('obj-valor-produto');

        $('.produto_id').val(id);
        $('.produto_nome').val(nome);
        $('.valor_base').val(preco);

        $('#ModalEditarProduto').modal('show');       
    });

    $('.url-modal-submit-form-editar-produto').on('click', function() {
        $('.form-editar-produto').submit();
    });

    $('.btn-excluir-produto').on('click', function() {
        var id = $(this).attr('obj-id-produto');
        $('#url-modal-excluir-produto').attr('href', '/produtos/excluir/' + id);
        $('#ModalExcluirProduto').modal('show');
    });
</script>
@endsection