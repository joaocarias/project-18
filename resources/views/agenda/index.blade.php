@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agendas</li>
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

    <form method="GET" action="{{ route('agendas') }}">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header">{{ __('Filtro') }}</div>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="data_agenda" class="col-form-label">{{ __('* Data') }}</label>

                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i> </div>
                                    </div>
                                    <input id="data_agenda" type="text" class="form-control @error('data_agenda') is-invalid @enderror datepicker" name="data_agenda" value="{{ old('data_agenda', $model->getData_agenda() ?? '') }}" autocomplete="off" required>
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

                                    @foreach($model->getProfissionais() as $item)
                                    <option value="{{ __($item->id) }}" @if ( old('profissional_id', $model->getProfissional_id() ?? '' ) == $item->id ) {{ 'selected' }} @endif>{{ __($item->nome) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">

                                <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-search"></i> Buscar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{ __('Agenda') }}</div>
                <div class="card-body">

                    @if(isset($model) && count($agendas) )

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Situação</th>
                                <th scope="col">Data e Horário</th>
                                <th scope="col">Paciente</th>
                               
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($agendas as $item)

                            <tr>
                                <td scope="row">{{ __($item->id) }}</td>
                                <td><span class="badge badge-{{ $item->situacaoCor() }}">{{ $item->situacaoStatus() }}</span></td>
                                <td>{{ __($item->dataAgendamento()) }}</td>                                
                                <td></td>               
                                <td class="text-right">
                                    <a href="{{ route('editar_tipo_profissional', ['id' => $item->id ]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Editar </a>
                                    <a href="#" class="btn btn-danger btn-sm btn-excluir" obj-id="{{ $item->id }}"> <i class="far fa-trash-alt"></i> Excluir </a>
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

                    <hr />

                    <a href="#" class="btn btn-success btn-liberar-agenda" profissional-id="{{ $model->getProfissional_id() }}" profissional-nome="{{ $model->getProfissional_nome() }}" data="{{ $model->getData_agenda() }}"> <i class="far fa-calendar-alt"></i> Liberar Agenda</a>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Liberar Agenda -->
    <div class="modal fade" id="ModalLiberarAgenda" tabindex="-1" role="dialog" aria-labelledby="TituloModalLiberarAgenda" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TituloModalLiberarAgenda"><i class="far fa-calendar-alt"></i> Liberar Agenda </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="GET" class="form-liberar" action="{{ route('liberar_agenda') }}">

                        <input type="hidden" id="liberar_profissional_id" name="liberar_profissional_id" value="{{ $model->getProfissional_id() }}" />
                        <input type="hidden" id="hidden_liberar_data_agenda" name="hidden_liberar_data_agenda" value="{{ $model->getData_agenda() }}" />

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="liberar_horario_agenda" class="col-form-label">{{ __('* Horário') }}</label>

                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-clock"></i> </div>
                                    </div>
                                    <input id="liberar_horario_agenda" type="text" class="form-control @error('liberar_horario_agenda') is-invalid @enderror time-hh-mm" name="liberar_horario_agenda" value="{{ old('liberar_horario_agenda', '' ?? '') }}" autocomplete="off" required>
                                </div>
                                
                                <div class="liberar_horario_agenda_error" role="alert">
                                  
                                </div>
                                
                            </div>

                            <div class="col-md-3">
                                <label for="liberar_data_agenda" class="col-form-label">{{ __('* Data') }}</label>

                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i> </div>
                                    </div>
                                    <input id="liberar_data_agenda" type="text" class="form-control @error('liberar_data_agenda') is-invalid @enderror" name="liberar_data_agenda" value="{{ old('liberar_data_agenda', $model->getData_agenda() ?? '') }}" autocomplete="off" disabled>
                                </div>
                                @error('liberar_data_agenda')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="liberar_profissional_nome" class="col-form-label">{{ __('* Profissional') }}</label>
                                <input id="liberar_profissional_nome" type="text" class="form-control @error('liberar_profissional_nome') is-invalid @enderror" name="liberar_profissional_nome" value="{{ old('liberar_profissional_nome', $model->getProfissional_nome() ?? '') }}" autocomplete="off" disabled>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <a id="btn-submit-form-liberar" href="#" class="btn btn-danger btn-submit-form-liberar"> <i class="far fa-save"></i> Liberar</a>
                    <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    @endsection

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

    <script type="text/javascript">
        $('.btn-liberar-agenda').on('click', function() {            
            $('#ModalLiberarAgenda').modal('show');
        });

        $('.btn-submit-form-liberar').on('click', function(){
            
            var liberar_horario = $('#liberar_horario_agenda').val();
            if(liberar_horario != ""){
                $('.form-liberar').submit();
            } else{
               console.log(liberar_horario.lenght);
                $('.liberar_horario_agenda_error').html("<strong>Campo Inválido!<strong>");
            }          
        });
    </script>
    @endsection