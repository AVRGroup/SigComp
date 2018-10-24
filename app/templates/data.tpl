{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Carga de Dados</h3>
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item">
            <a href="{path_for name="adminDataLoad"}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Atualizar dados de alunos</a>
        </li>
        <li class="nav-item">
            <a href="{path_for name="gradeLoadAction"}" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Cadastrar nova grade</a>
        </li>
    </ul>
{/block}