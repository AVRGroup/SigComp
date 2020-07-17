{extends 'layout.tpl'}

{block name=content}
        <h3 class="text-center">Criar Novo Grupo</h3>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <b>Atenção!</b> Só é possível cadastrar 4 grupos para um curso. O 5º grupo sempre será reservado para as disciplinas eletivas e optativas.
        Seu nome padrão é "Multidisciplinaridade", mas pode ser editado.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <div align="center" style="margin-bottom: 2%;">
        {if isset($error)}
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {$error}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        {/if}
    </div>

    <p align="center">Selecione um curso</p>
        <div align="center">
            <div class="form-row col-md-4 mt-4 justify-content-center">
                <select class="form-control col-6" name="grade-selecionada" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    {foreach $cursos as $curso}
                        <option {if $curso == $cursoSelecionado} selected {/if} value="{base_url}/admin/create-grupo?cursoSelecionado={$curso}">{$curso} </option>
                    {/foreach}
                </select>
            </div>
        </div>

    <div align="center" class="mt-4">
        <h5>Grupos já cadastrados</h5>
        <div class="text-left" style="margin-left: 30%">
            <ul>
                {foreach $grupos as $grupo}
                    {if $grupo->getCurso() == $cursoSelecionado }
                        <a>• <strong>{$grupo->getCurso()}</strong> - {$grupo->getNome()}<br></a>
                    {/if}
                {foreachelse}
                    <p>Ainda não há grupos cadastrados</p>
                {/foreach}
            </ul>
        </div>
    </div> 

    <hr>
    <div align="center">
        <div class="form-group">
            <form action="{base_url}/admin/store-grupo" method="post">
                <label for="nome" class="mt-4"><strong>Nome do grupo:</strong></label>
                <input type="text" class="form-control col-sm-6 mb-3" name="nome" id="nome">

                    <a style="font-size: 15px"><strong> Selecione o curso</strong> </a>
                    <select class="form-control col-md-6 text-center" name="dropDown" id="grupo">
                        <option value="" disabled>Selecione um grupo</option>
                        {foreach $cursos as $cur}
                            <option value="{$cur}" selected> {$cur} </option>
                        {/foreach}
                    </select>
    
                <button class="btn btn-success mt-4" style="width: 200px">Criar grupo</button>
            </form>
        </div>
    </div>
{/block}