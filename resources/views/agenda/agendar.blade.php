@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">

        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agendas') }}">Agenda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agendar</li>
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
                <div class="card-header">{{ __('Paciente') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            Nome: <strong>{{ __($paciente->nome)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            CPF: <strong>{{ __($paciente->cpf)  }}</strong>
                        </div>

                        <div class="col-md-3">
                            Arquivo: <strong>{{ __($paciente->numero_ficha)  }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header">{{ __('Filtro') }}</div>
                    <div class="card-body">

                    <form method="GET" action="{{ route('agendar_agenda', ['pacienteId' => $pacienteId]) }}">

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="data_agenda" class="col-form-label">{{ __('* Data') }}</label>

                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i> </div>
                                    </div>
                                    <input id="data_agenda" type="text" class="form-control @error('data_agenda') is-invalid @enderror datepicker" name="data_agenda" value="{{ old('data_agenda', $dataForm ?? '') }}" autocomplete="off" required>
                                </div>
                                @error('data_agenda')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="profissional_id" class="col-form-label">{{ __('* Profissional') }}</label>

                                <select id="profissional_id" type="text" class="form-control @error('profissional_id') is-invalid @enderror" name="profissional_id" autocomplete="profissional_id" required>
                                    <option selected disabled>-- Selecione --</option>

                                    @foreach($profissionais as $item)
                                    <option value="{{ __($item->id) }}" @if ( old('profissional_id', $profissional->id ?? '' ) == $item->id ) {{ 'selected' }} @endif>{{ __($item->nome) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-search"></i> Buscar</button>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    @if(isset($agendasProfissional) && isset($profissional) && !is_null($profissional) )

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Agenda') }} de <strong>{{ __($profissional->nome) }}</strong></div>
                <div class="card-body">

                    @if(count($agendasProfissional) > 0 )

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Situação</th>
                                <th scope="col">Data e Horário</th> 
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                    
                            @foreach ($agendasProfissional as $item)

                            <tr>
                                <td scope="row">{{ __($item->id) }}</td>
                                <td><span class="badge badge-{{ $item->situacaoCor() }}">{{ $item->situacaoStatus() }}</span></td>
                                <td>{{ __($item->dataAgendamento()) }}</td>
                               
                                <td class="text-right">
                                    <form method="POST" action="{{ route('update_agenda', [ 'id' => $item->id ]) }}">
                                        @csrf
                                        @method('put')

                                        <input type="hidden" value="{{ $pacienteId }}" id="paciente_id" name="paciente_id">

                                        <button type="submit" class="btn btn-success">
                                            <i class="far fa-save"></i>
                                            {{ __('Agendar') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>

                    @else
                    <div class="alert alert-warning" role="alert">
                        Não foi encontrado agenda para o profissional.
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    @endif



    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Agendamentos do Paciente') }}</div>

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

                                        <th scope="col"></th>
                                    <tr>
                                </thead>
                                <tbody>
                                    @foreach ($agendamentos as $item)

                                    <tr>
                                        <td scope="row">{{ __($item->id) }}</td>
                                        <td><span class="badge badge-{{ $item->situacaoCor() }}">{{ $item->situacaoStatus() }}</span></td>
                                        <td>{{ __($item->dataAgendamento()) }}</td>
                                        <td class="text-right"> </td>
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

@section('javascript')
<script type="text/javascript">
    $(document).ready(function($) {
        $('.time-hh-mm').mask('00:00');

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            // endDate: '{{__(date("d/m/Y"))}}',
            todayBtn: 'linked',
            todayHighlight: true,
        });
    });
</script>
@endsection