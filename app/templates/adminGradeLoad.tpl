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
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Carga efetuada com sucesso!<br/>
            {foreach($keys as $key)}
                {$key} - Disciplina(s) adicionada(s): {$affectedData[$key]}<br/>
            {/foreach}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    <div style="padding: 10px 20px;">
        Grades já cadastradas para o seu curso:
        <ul style="margin-top: 10px">
            {foreach $grades as $grade}
                    <li style="margin-bottom: 10px"><b>{$grade->getCodigo()}</b> - {$grade->getCurso()}</li>
            {foreachelse}
                    <li>Nenhuma grade encontrada para esse curso</li>
            {/foreach}
        </ul>
    </div>

{/block}
