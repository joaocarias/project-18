@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">

        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pacientes') }}">Pacientes</a></li>
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

    @if(isset($paciente) && ($paciente->id > 0) )

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Detalhes') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Nome: <strong>{{ __($paciente->nome)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            CPF: <strong>{{ __($paciente->cpf)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            Genero: <strong>{{ __($paciente->genero)  }}
                            </strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            Arquivo: <strong>{{ __($paciente->numero_ficha)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            Data de Nascimento: <strong>{{ __($paciente->dataNascimento())  }}</strong>
                        </div>

                        <div class="col-md-3">
                            Telefone: <strong> {{ __($paciente->telefone)  }}
                            </strong>
                        </div>

                        <div class="col-md-3">
                            E-mail: <strong> {{ __($paciente->email)  }}
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
                            <a href="{{ route('editar_paciente', ['id' => $paciente->id ]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar </a>
                            <a href="#" class="btn btn-danger btn-sm btn-excluir" id-paciente="{{ $paciente->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Agendamentos') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($agendamentos) && count($agendamentos) > 0)
                            <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Situação</th>
                                <th scope="col">Data e Horário</th>                              
                                <th scope="col">Profissional</th>  
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($agendamentos as $item)

                            <tr>
                                <td scope="row">{{ __($item->id) }}</td>
                                <td><span class="badge badge-{{ $item->situacaoCor() }}">{{ $item->situacaoStatus() }}</span></td>
                                <td>{{ __($item->dataAgendamento()) }}</td>    
                                <td>{{ __($item->profissional->nome) }}</td>                              
                                <td class="text-right">   </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                            @else
                            <div class="alert alert-warning" role="alert">
                                Não Encontrou Registros!
                            </div>
                            @endif
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('agendar_agenda', ['pacienteId' => $paciente->id ]) }}" class="btn btn-success btn-sm"><i class="far fa-calendar-alt"></i> Agendar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

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
        var id = $(this).attr('id-paciente');
        $('#url-modal-excluir').attr('href', '/pacientes/excluir/' + id);
        $('#ModalExcluir').modal('show');
    });
</script>
@endsection