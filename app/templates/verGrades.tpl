{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Editar Grade</h3>
    
    <div class="form-row mt-4 justify-content-center">
        <select class="form-control col-6" name="grade-selecionada" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            {foreach $todasGrades as $grade}
                <option {if $grade->getCodigo() == $gradeSelecionada->getCodigo() && $grade->getCurso() == $gradeSelecionada->getCurso()} selected {/if} value="{base_url}/admin/ver-grade?grade={$grade->getCodigo()}&curso={$grade->getCurso()}">{$grade->getCodigo()} - {$grade->getCurso()} </option>
            {/foreach}
        </select>
    </div>

    <h5 class="text-center mt-4">Você está editando a grade: {$gradeSelecionada->getCodigo()} - curso: {$gradeSelecionada->getCurso()} </h5>

    {if isset($sucesso) && $sucesso}
    <div align="center">
        <div class="alert alert-success alert-dismissable show fade mt-4 col-8">
            Disciplina alterada com sucesso
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
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