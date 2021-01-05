<div class="form-group row">
    <div class="col-md-12">
        <label for="nome" class="col-form-label">{{ __('* Nome') }}</label>
        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', $empresa->nome ?? '') }}" autocomplete="nome" autofocus required maxlength="254">

        @error('nome')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    
</div>


<div class="form-group row">
    <div class="col-md-6">
        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $empresa->email ?? '') }}" autocomplete="email">

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="telefone" class="col-form-label">{{ __('Telefone') }}</label>
        <input id="telefone" type="text" class="mask_telefone form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone', $empresa->telefone ?? '') }}" autocomplete="telefone">

        @error('telefone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>