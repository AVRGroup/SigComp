{extends 'layout.tpl'}
{block name=content}
    <div style="margin: 0 20px">
        <h3 style="margin-bottom: 30px;" class="text-center">Oportunidades</h3>

        {if $loggedUser->getTipo() == 1}
            <div class="text-center">
                <a class="btn btn-lg btn-success" href="{path_for name="cadastrarOportunidade"}" style="color: #fff; margin-bottom: 5%">Cadastrar Oportunidade </a>
            </div>
        {/if}

        <div class="row">
            {foreach $oportunidades as $oportunidade}
                <div class="col-6">
                    <div class="card-oportunidade card-oportunidade-{$oportunidade->abreviacao()}">

                        <p class="text-center titulo">
                            <span class="borda-titulo-{$oportunidade->abreviacao()}">{$oportunidade->getNomeTipo()}</span>
                        </p>

                        <p class="descricao">{$oportunidade->getDescricao()}</p>

                        <p><span class="weight-600">Professor:</span> {$oportunidade->getProfessor()}</p>

                        <p><span class="weight-600">Vagas:</span> {$oportunidade->getQuantidadeVagas()}</p>

                        <p><span class="weight-600">Data limite para Inscrição:</span> {$oportunidade->getValidade()->format('d/m/Y')}</p>

                        <p>
                            <span class="weight-600">Remuneração:</span>
                            {if $oportunidade->getRemuneracao() == 0}
                                Voluntária
                            {else}
                                R${number_format($oportunidade->getRemuneracao(), 2, '.', '')}
                            {/if}
                        </p>

                        <button type="button" class="btn btn-{$oportunidade->abreviacao()}" data-toggle="modal" data-target="#maisInformacoes"
                        data-arquivo="{base_url}/upload/{$oportunidade->getArquivo()}">
                            Mais Informações
                        </button>

                    </div>
                </div>
            {/foreach}
        </div>
    </div>



    <div class="modal fade" id="maisInformacoes" tabindex="-1" role="dialog" aria-labelledby="maisInformacoesLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="maisInformacoesLabel">Pré-Requisitos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a class="download-aquivo" href="">Ver Arquivo</a>
                </div>
            </div>
        </div>
    </div>
{/block}


{block name="javascript"}
    <script>
        $('#maisInformacoes').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var arquivo = button.data('arquivo')

            var modal = $(this)
            modal.find('.modal-body a').attr("href", arquivo)

        })


    </script>

{/block}