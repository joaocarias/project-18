<!-- Modal Editar Produto Fornecedor -->
<div class="modal fade" id="ModalEditarProdutoFornecedor" tabindex="-1" role="dialog" aria-labelledby="TituloModalEditarProdutoFornecedor" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalEditarProdutoFornecedor"><i class="fas fa-exclamation-circle"></i> Editar Produto!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
        <form method="POST" action="{{ route('update_produto_fornecedor') }}" class="form-editar-produto-fornecedor">
                @csrf
                @method('put')

                    <input type="hidden" class="fornecedor_id" name="fornecedor_id" id="fornecedor_id" value="">
                    <input type="hidden" name="produto_fornecedor_id" id="produto_fornecedor_id" class="produto_fornecedor_id" value="">

                    <div class="col-md-9">
                        <label for="produto_fonecedor_nome" class="col-form-label text-md-right">{{ __('* Nome') }}</label>
                        <input id="produto_fonecedor_nome" type="text" class="produto_fonecedor_nome form-control @error('produto_fonecedor_nome') is-invalid @enderror" name="produto_fonecedor_nome" value="" autocomplete="produto_fonecedor_nome" required maxlength="255" minlength="3">

                        @error('produto_fonecedor_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="valor_base" class="col-form-label text-md-right">{{ __('* Valor (R$)') }}</label>
                        <input id="valor_base" type="text" class="valor_base form-control @error('valor_base') is-invalid @enderror mask_moeda_real" name="valor_base" value="" autocomplete="valor_base" required maxlength="10" minlength="3">

                        @error('valor_base')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button href="#" class="btn btn-primary url-modal-submit-form-editar-produto-fornecedor"> <i class="far fa-save"></i> Editar Produto</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal"> <i class="fas fa-ban"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
