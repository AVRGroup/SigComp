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

                        <button class="btn btn-{$oportunidade->abreviacao()}">Mais Informações</button>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/block}