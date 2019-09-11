{extends 'layout.tpl'}
{block name=content}
    <div style="padding: 20px;">
        <div class="text-center" style="margin-top: 20px">
            <p class="oportunidade-unica-descicao">{$oportunidade->getDescricao()}</p>
<<<<<<< HEAD

=======
            <p style="margin-top: 20px"><span class="weight-600">Professor:</span> {$oportunidade->getProfessor()}</p>
>>>>>>> db0762b483abbf852ba0b6eccea85cbe0d13c922
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
<<<<<<< HEAD
                <span class="weight-600">Período Minimo: {$oportunidade->getPeriodoMinimoParaEscrita()}</span>
                |
                <span class="weight-600">Período Máximo: {$oportunidade->getPeriodoMaximoParaEscrita()}</span>
=======
                <span class="weight-600">Período Minimo: </span> {$oportunidade->getPeriodoMinimoParaEscrita()}
                |
                <span class="weight-600">Período Máximo: </span> {$oportunidade->getPeriodoMaximoParaEscrita()}
>>>>>>> db0762b483abbf852ba0b6eccea85cbe0d13c922
            </div>
        </div>

        <hr>

<<<<<<< HEAD
        <div style="margin-top: 20px" class="row">
            <div class="col-6">
                <p><span class="weight-600">Profressor:</span> {$oportunidade->getProfessor()}</p>
                <p><span class="weight-600">Prazo para Inscrição:</span> {$oportunidade->getValidade()->format('d/m/Y')}</p>
                <p><span class="weight-600">Vagas:</span> {$oportunidade->getQuantidadeVagas()}</p>

                <p>
                    <span class="weight-600">Remuneração:</span>
=======
        <div style="margin-top: 20px" class="text-center" >
            <p>
                <span style="display: inline-block; margin-right: 20px"> <span class="weight-600">Prazo para Inscrição:</span> {$oportunidade->getValidade()->format('d/m/Y')} </span>
                <span style="display: inline-block; margin-right: 20px"><span class="weight-600">Vagas:</span> {$oportunidade->getQuantidadeVagas()}</span>
                <span class="weight-600">Remuneração:</span>
>>>>>>> db0762b483abbf852ba0b6eccea85cbe0d13c922
                    {if $oportunidade->getRemuneracao() == 0}
                        Voluntária
                    {else}
                        R${number_format($oportunidade->getRemuneracao(), 2, '.', '')}
                    {/if}
<<<<<<< HEAD
                </p>
            </div>

            {if isset($oportunidade->getArquivo())}
                <div class="col-6">
                    {if $oportunidade->getExtensao() == "pdf"}
                        <object data="{base_url}/upload/{$oportunidade->getArquivo()}"  type="application/pdf"></object>
                    {else}
                        <img alt="pdf-oportunidade" class="card-img-top" src="{base_url}/upload/{$oportunidade->getArquivo()}">
                    {/if}
                    <br>
                    <a href="{base_url}/upload/{$oportunidade->getArquivo()}" target="_blank"> Download </a>
                </div>
            {/if}

        </div>

    </div>
=======
            </p>
        </div>

        {if isset($oportunidade->getArquivo())}
            <div class="text-center">
                <a href="{base_url}/upload/{$oportunidade->getArquivo()}" target="_blank"> Download do Arquivo </a>
            </div>
        {/if}

        </div>
>>>>>>> db0762b483abbf852ba0b6eccea85cbe0d13c922
{/block}