{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Editar Grupos</h3>

    <div class="text-center mt-4">
        <a href="{base_url}/admin/create-grupo" class="btn btn-primary btn-lg">Criar Novo Grupo</a>
        <a class="btn btn-outline-success btn-lg ml-4" style="width: 150px" href="{base_url}/admin/editar-grupos">Editar Grupos</a>
    </div>
    <hr>

    <h5 class="text-center" style="font-style: italic"> Selecione uma grade para editar os grupos </h5>
    <form action="{base_url}/admin/store-disciplina-grupo" method="post">
        <div class="form-row mt-2 justify-content-center">
            <select class="form-control col-6" name="grade-selecionada" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                {foreach $todasGrades as $grade}
                    <option {if $grade->getCodigo() == $gradeSelecionada->getCodigo() && $grade->getCurso() == $gradeSelecionada->getCurso()} selected {/if} value="{base_url}/admin/ver-grupo?grade={$grade->getCodigo()}&curso={$grade->getCurso()}">{$grade->getCodigo()} - {$grade->getCurso()}</option>
                {/foreach}
            </select>
        </div>
        
        <table style="margin-top: 4%" id="tabela" class="table table-hover">
            <thead class="thead-light">
            <tr style="font-size: 13px;">
                <th scope="col">Codigo ↑↓</th>
                <th scope="col">Nome ↑↓</th>
                <th scope="col">Grupo ↑↓</th>
            </tr>
            </thead>
            <tbody>
            {foreach $disciplinas as $index => $disciplina}
                {if $disciplina->getCodigo() == ""}
                    {continue}
                {/if}
                <tr>
                    <td>{$disciplina->getCodigo()}</td>
                    <td>{$disciplina->getNome()}</td>
                    <td>
                        <select class="form-control" name="{$disciplina->getCodigo()}" id="grupo">
                            <option value="" disabled>Selecione um grupo</option>
                            {foreach $grupos as $grupo}
                                <option value="{$grupo->getId()}"
                                        {if isset($disciplina->getGrupo($container, $curso)) && $disciplina->getGrupo($container, $curso)->getId() == $grupo->getId()} selected {/if}>
                                        {$grupo->getNome()}
                                </option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>

        <div align="center">
            <button type="submit" style="width: 200px" class="btn btn-success">Salvar</button>
        </div>
    </form>
{/block}