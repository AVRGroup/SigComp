{extends 'layout.tpl'}
{block name=content}
    <div style="padding: 20px;">
        <div class="text-center" style="margin-top: 20px">
            <p class="oportunidade-unica-descicao">{$oportunidade->getDescricao()}</p>
            <p style="margin-top: 20px"><span class="weight-600">Quem está oferecendo:</span> {$oportunidade->getProfessor()}</p>
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
                <span class="weight-600">Período Minimo: </span> {$oportunidade->getPeriodoMinimoParaEscrita()}
                |
                <span class="weight-600">Período Máximo: </span> {$oportunidade->getPeriodoMaximoParaEscrita()}
            </div>
        </div>

        <hr>

        <div style="margin-top: 20px" class="text-center" >
            <p>
                <span style="display: inline-block; margin-right: 20px"> <span class="weight-600">Prazo para Inscrição:</span> {$oportunidade->getValidade()->format('d/m/Y')} </span>

                <span style="display: inline-block; margin-right: 20px">
                    <span class="weight-600">Vagas:</span>
                    {if $oportunidade->getQuantidadeVagas() == -1}
                        Não Informado
                    {else}
                        {$oportunidade->getQuantidadeVagas()}
                    {/if}
                </span>

                <span class="weight-600">Remuneração:</span>
                {if $oportunidade->getRemuneracao() == 0}
                    Voluntária
                {elseif $oportunidade->getRemuneracao() == -1}
                    Não Informada
                {else}
                    R${number_format($oportunidade->getRemuneracao(), 2, '.', '')}
                {/if}
            </p>
        </div>

        {if isset($oportunidade->getArquivo())}
            <div class="text-center">
                <a href="{base_url}/upload/{$oportunidade->getArquivo()}" target="_blank"> Download do Arquivo </a>
            </div>
        {/if}

        </div>
{/block}