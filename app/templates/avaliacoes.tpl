{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Avaliação </h2>
    <!-- 01#!/79awQxVp -->
    <hr>
            <p align="center" class="font-italic" style="font-size: 24px;"> Selecione uma disciplina </p>

    <div class="row container ">
        <div align="center" class="col-lg-12 col-sm-12 col-md-12" >
            <div class="row">
                {$notas_usuario = $usuario->getNotas()}
                {foreach $notas_usuario as $nota}
                    {if $nota->getPeriodo() == $periodoPassado}
                        <a href="{path_for name="avaliacaoPage01"}?disciplina={$nota->getDisciplina()->getId()}" class="text-truncate btn btn-primary btn-lg active col-lg-6 col-sm-12 col-md-12" style="margin-top: 1%" role="button" aria-pressed="true">{$nota->getDisciplina()->getCodigo()} - {$nota->getDisciplina()->getNome()}</a>
                    {/if}
                {/foreach}
            </div>
        </div>
    </div>

{/block}