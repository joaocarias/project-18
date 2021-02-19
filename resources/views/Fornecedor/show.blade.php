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
                                <td>{{ __($item->valor_base) }}</td>
                                <td>{{ __($item->usuarioCadastro->name) }}</td>
                                <td>{{ __($item->dataCadastro()) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('editar_tipo_profissional', ['id' => $item->id ]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar </a>
                                    <a href="#" class="btn btn-danger btn-sm btn-excluir" obj-id="{{ $item->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
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

<!-- Modal Associar Permissao -->
<div class="modal fade" id="ModalInserirProdutoFornecedor" tabindex="-1" role="dialog" aria-labelledby="TituloModalInserirProdutoFornecedor" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalProdutoFornecedor"><i class="fas fa-exclamation-circle"></i> Inserir Produto!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('cadastrar_produto_fornecedor') }}" class="form-inserir-produto-fornecedor">
                    @csrf

                    <input type="hidden" name="fornecedor_id" id="fornecedor_id" value="{{ __($fornecedor->id) }}">

                    <div class="col-md-9">
                        <label for="produto_fonecedor_nome" class="col-form-label text-md-right">{{ __('* Nome') }}</label>
                        <input id="produto_fonecedor_nome" type="text" class="form-control @error('produto_fonecedor_nome') is-invalid @enderror" name="produto_fonecedor_nome" value="{{ old('produto_fornecedor_nome', $produto_fonecedor->nome ?? '') }}" autocomplete="produto_fonecedor_nome" required maxlength="255" minlength="3">

                        @error('produto_fonecedor_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="valor_base" class="col-form-label text-md-right">{{ __('* Valor (R$)') }}</label>
                        <input id="valor_base" type="text" class="form-control @error('valor_base') is-invalid @enderror mask_moeda_real" name="valor_base" value="{{ old('valor_base', $produto_fornecedor->valor_base ?? '') }}" autocomplete="valor_base" required maxlength="10" minlength="3">

                        @error('valor_base')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button href="#" class="btn btn-primary url-modal-submit-form-produto-fornecedor"> <i class="far fa-save"></i> Inserir Produto</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

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
</script>
@endsection