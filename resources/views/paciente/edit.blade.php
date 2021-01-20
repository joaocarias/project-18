@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">       
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i class="fas fa-home"></i> &nbsp; Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pacientes') }}">Pacientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Cadastro</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

        <form method="POST" action="{{ route('update_paciente', [ 'id' => $paciente->id ]) }}">
                @csrf
                @method('put')

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">{{ __('Editar') }}</div>
                            <div class="card-body">
                                
                            <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="nome" class="col-form-label text-md-right">{{ __('* Nome') }}</label>
                                        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $paciente->nome ?? '') }}" autocomplete="nome" maxlength="255" required>

                                        @error('nome')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="numero_ficha" class="col-form-label text-md-right">{{ __('Arquivo') }}</label>
                                        <input id="numero_ficha" type="text" class="form-control @error('numero_ficha') is-invalid @enderror" name="numero_ficha" value="{{ old('numero_ficha', $paciente->numero_ficha ?? '') }}" autocomplete="numero_ficha" maxlength="10">

                                        @error('numero_ficha')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="cpf" class="col-form-label text-md-right">{{ __('CPF') }}</label>
                                        <input id="cpf" type="text" class="mask_cpf form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf', $paciente->cpf ?? '') }}" autocomplete="cpf" maxlength="14">

                                        @error('cpf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="data_nascimento" class="col-form-label text-md-right">{{ __('Data de Nascimento') }}</label>
                                        <input id="data_nascimento" type="text" class="form-control datepicker @error('data_nascimento') is-invalid @enderror" name="data_nascimento" value="{{ old('data_nascimento', $paciente->data_nascimento ?? '') }}" autocomplete="data_nascimento" maxlength="20">

                                        @error('data_nascimento')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="genero" class="col-form-label text-md-right">{{ __('Gênero') }}</label>

                                        <select id="genero" type="text" class="form-control @error('genero') is-invalid @enderror" name="genero">
                                            <option selected disabled>-- Selecione --</option>

                                            <option value="MASCULINO" @if ( old('genero', $paciente->genero ?? '' ) == 'MASCULINO' ) {{ 'selected' }} @endif>{{ __('MASCULINO') }}</option>
                                            <option value="FEMININO" @if ( old('genero', $paciente->genero ?? '' ) == 'FEMININO' ) {{ 'selected' }} @endif>{{ __('FEMININO') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="telefone" class="col-form-label text-md-right">{{ __('Telefone') }}</label>
                                        <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone', $paciente->telefone ?? '') }}" autocomplete="telefone" maxlength="20">

                                        @error('telefone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail') }}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $paciente->email ?? '') }}" autocomplete="email" maxlength="254">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">{{ __('Endereço') }}</div>
                            <div class="card-body">
                                @include('endereco._formEndereco')
                            </div>
                        </div>
                    </div>
                </div>               

                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="far fa-save"></i>
                            {{ __('Salvar') }}
                        </button>

                        <a href="{{ route('pacientes') }}" class="btn btn-warning">
                            <i class="far fa-times-circle"></i>
                            {{ __('Cancelar') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function($) {
        $('.mask_cpf').mask('000.000.000-00');

        var SPMaskBehavior = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        $('#telefone').mask(SPMaskBehavior, spOptions);
    });

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR',
        endDate: '{{__(date("d/m/Y"))}}',
        todayBtn: 'linked',
        todayHighlight: true,
    });
</script>

@endsection