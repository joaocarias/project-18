<!-- Modal Associar Produto Fornecedor -->
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
