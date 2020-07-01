{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Editar Grade</h3>

    <h5 class="text-center">(curso {$todasGrades[0]->getCurso()})</h5>

    <div class="form-row mt-4">
        <select class="form-control col-6" name="grade-selecionada" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            {foreach $todasGrades as $grade}
                <option {if $grade->getCodigo() == $gradeSelecionada->getCodigo()} selected {/if} value="{base_url}/admin/ver-grade?grade={$grade->getCodigo()}">{$grade->getCodigo()}</option>
            {/foreach}
        </select>
    </div>

    {if isset($sucesso) && $sucesso}
        <div class="alert alert-success alert-dismissable show fade mt-4">
            Disciplina alterada com sucesso
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    <table style="margin-top: 4%" id="tabela" class="table table-hover">
        <thead class="thead-light">
        <tr style="font-size: 13px;">
            <th scope="col">Codigo ↑↓</th>
            <th scope="col">Nome ↑↓</th>
            <th scope="col">Carga Horária ↑↓</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        {foreach $disciplinas as $index => $disciplina}
            <tr>
                <td>{$disciplina->getCodigo()}</td>
                <td>{$disciplina->getNome()}</td>
                <td>{$disciplina->getCarga()}</td>
                <td><a href="{base_url}/admin/editar-grade/{$disciplina->getId()}">Editar</a></td>
            </tr>
        {/foreach}
        </tbody>
    </table>    
{/block}