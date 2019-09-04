{extends 'layout.tpl'}
{block name=content}
    <div style="padding: 20px;">
        <div class="text-center" style="margin-top: 20px">
            <p class="oportunidade-unica-descicao">{$oportunidade->getDescricao()}</p>

            <hr>

            {foreach $oportunidade->getDisciplinas() as $disciplina}
                {if in_array($disciplina->getId(), $disciplinasAprovadas)}
                    <span style="background-color: #74eb56" class="oportunidade-unica-requisitos">
                {else}
                    <span style="background-color: #F96262" class="oportunidade-unica-requisitos">
                {/if}
                    {if $disciplina->getNome()}
                        {$disciplina->getNome()}
                    {else}
                        {$disciplina->getCodigo()}
                    {/if}
                </span>
            {/foreach}
            <div style="margin-top: 10px">
                <span class="weight-600">Minimo: {$oportunidade->getPeriodoMinimo()}º período</span>
                |
                <span class="weight-600">Máximo: {$oportunidade->getPeriodoMaximo()}º período</span>
            </div>
        </div>

        <hr>

        <div style="margin-top: 20px" class="row">
            <div class="col-6">
                <p><span class="weight-600">Profressor:</span> {$oportunidade->getProfessor()}</p>
                <p><span class="weight-600">Prazo para Inscrição:</span> {$oportunidade->getValidade()->format('d/m/Y')}</p>
                <p><span class="weight-600">Vagas:</span> {$oportunidade->getQuantidadeVagas()}</p>

                <p>
                    <span class="weight-600">Remuneração:</span>
                    {if $oportunidade->getRemuneracao() == 0}
                        Voluntária
                    {else}
                        R${number_format($oportunidade->getRemuneracao(), 2, '.', '')}
                    {/if}
                </p>
            </div>

            <div class="col-6">
                {if $oportunidade->getExtensao() == "pdf"}
                    <embed src="{base_url}/upload/{$oportunidade->getArquivo()}" type="application/pdf">
                {else}
                    <img class="card-img-top" src="{base_url}/upload/{$oportunidade->getArquivo()}">
                {/if}
                <br>
                <a href="{base_url}/upload/{$oportunidade->getArquivo()}" target="_blank"> Download </a>
            </div>

        </div>

    </div>
{/block}