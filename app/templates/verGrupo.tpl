{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Editar Grupos</h3>

    <div class="text-center mt-4">
        <a href="{base_url}/admin/create-grupo" class="btn btn-primary btn-lg">Criar Novo Grupo</a>
    </div>



    <form action="{base_url}/admin/store-disciplina-grupo" method="post">
        <div class="form-row mt-4">
            <select class="form-control col-6" name="grade-selecionada" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                {foreach $todasGrades as $grade}
                    <option {if $grade->getCodigo() == $gradeSelecionada->getCodigo()} selected {/if} value="{base_url}/admin/ver-grupo?grade={$grade->getCodigo()}">{$grade->getCodigo()}</option>
                {/foreach}
            </select>
        </div>
        <a class="btn btn-success mt-4" href="{base_url}/admin/editar-grupos">Editar Grupos</a>

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
                <tr>
                    <td>{$disciplina->getCodigo()}</td>
                    <td>{$disciplina->getNome()}</td>
                    <td>
                        <select class="form-control" name="{$disciplina->getCodigo()}" id="grupo">
                            <option value="">Selecione um grupo</option>
                            {foreach $grupos as $grupo}
                                <option value="{$grupo->getId()}"
                                        {if isset($disciplina->getGrupo($container, $curso)) && $disciplina->getGrupo($container, $curso)->getId() == $grupo->getId() } selected {/if}>
                                    {$grupo->getNome()}
                                </option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Salvar</button>

    </form>
{/block}