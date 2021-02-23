<!-- Modal Novo Produto -->
<div class="modal fade" id="ModalInserirProduto" tabindex="-1" role="dialog" aria-labelledby="TituloModalInserirProduto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalProduto"><i class="fas fa-exclamation-circle"></i> Inserir Produto!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('cadastrar_produto') }}" class="form-inserir-produto">
                    @csrf
  
                    <div class="col-md-9">
                        <label for="produto_nome" class="col-form-label text-md-right">{{ __('* Nome') }}</label>
                        <input id="produto_nome" type="text" class="form-control @error('produto_nome') is-invalid @enderror" name="produto_nome" value="{{ old('produto_nome', $produto->nome ?? '') }}" autocomplete="produto_nome" required maxlength="255" minlength="3">

                        @error('produto_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="valor_base" class="col-form-label text-md-right">{{ __('* Valor (R$)') }}</label>
                        <input id="valor_base" type="text" class="form-control @error('valor_base') is-invalid @enderror mask_moeda_real" name="valor_base" value="{{ old('valor_base', $produto->valor_base ?? '') }}" autocomplete="valor_base" required maxlength="10" minlength="3">

                        @error('valor_base')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button href="#" class="btn btn-primary url-modal-submit-form-produto"> <i class="far fa-save"></i> Inserir Produto</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
