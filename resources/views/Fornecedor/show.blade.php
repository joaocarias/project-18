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

    @endif

</div>

@include('layouts._modal_excluir')

@endsection

@section('javascript')
<script type="text/javascript">
    $('.btn-excluir').on('click', function() {
        var id = $(this).attr('id-fornecedor');
        $('#url-modal-excluir').attr('href', '/fornecedores/excluir/' + id);
        $('#ModalExcluir').modal('show');
    });
</script>
@endsection
