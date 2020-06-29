{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Carga de Dados</h3>
    <ul class="nav nav-pills nav-fill">	
        <li class="nav-item">	    <div align="center">
            <a href="{path_for name="adminDataLoad"}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Atualizar dados de alunos</a>	        <div class="alert alert-warning alert-dismissible fade show col-md-8" role="alert">
        </li>	            <b>Atenção!</b> Efetue um backup do banco de dados antes de atualizar os dados!
        <li class="nav-item">	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <a href="{path_for name="gradeLoadAction"}" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Cadastrar nova grade</a>	                <span aria-hidden="true">&times;</span>
        </li>	            </button>
    </ul>
    </div>

    <p align="center" style="font-weight: 500; font-size: 20px; margin-top: 2%">Ao clicar no botao abaixo, serão atualizados os dados dos alunos e inseridos os novos!</p>
        <div align="center" >
            <button href="{path_for name="gradeLoadAction"}" style="margin-top: 4%; width: 300px; height: 45px" class="btn btn-outline-dark" type="submit">Atualizar dados</button>  
        </div>


{/block}