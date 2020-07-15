{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Carga de Grade</h3>
    {if isset($error)}
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {$error}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}
    {if isset($success)}
        <div align="center">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Carga efetuada com sucesso!<br/>
                {$index = 0}
                {foreach $keys as $key}
                    Grade: <b>{$key}</b> - Disciplina(s) adicionada(s): <b>{$values[$index]}</b><br/>
                    {$index = $index + 1}
                {/foreach}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    {/if}

    <div style="padding: 10px 20px;">
        Grades já cadastradas:
        <ul style="margin-top: 10px">
            {foreach $grades as $grade}
                    <li style="margin-bottom: 10px"><b>{$grade->getCodigo()}</b> - {$grade->getCurso()}</li>
            {foreachelse}
                    <li>Nenhuma grade encontrada!</li>
            {/foreach}
        </ul>
    </div>

{/block}
