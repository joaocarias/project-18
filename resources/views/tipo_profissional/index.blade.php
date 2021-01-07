@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">        
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tipo Profissional</li>
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
                    <a href="{{ route('novo_tipo_profissional') }}" class="btn btn-primary">
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
                <div class="card-header">{{ __('Tipo Profissional') }}</div>
                <div class="card-body">
                    @if(isset($tipos_profissionais) && count($tipos_profissionais) > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Criado Por</th>
                                <th scope="col">Data de Criação</th>
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($tipos_profissionais as $item)
                            <tr>
                                <td scope="row">{{ __($item->id) }}</td>
                                <td>{{ __($item->nome) }}</td>
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
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Modal Excluir -->
<div class="modal fade" id="ModalExcluir" tabindex="-1" role="dialog" aria-labelledby="TituloModalExcluir" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalExcluir"><i class="fas fa-exclamation-circle"></i> Excluir!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja Excluir o Cadastro?</p>
            </div>
            <div class="modal-footer">
                <a id="url-modal-excluir" href="#" class="btn btn-danger"> <i class="far fa-trash-alt"></i> Confirmar e Excluir</a>
                <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $('.btn-excluir').on('click', function() {
        var id = $(this).attr('obj-id');
        $('#url-modal-excluir').attr('href', '/tipos_profissionais/excluir/' + id);
        $('#ModalExcluir').modal('show');
    });
</script>
@endsection