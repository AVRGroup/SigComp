{extends 'layout.tpl'}
{block name=content}  
    <h3 class="text-center">Carga de Dados</h3>

    {if $loggedUser->isAdmin()}
        <br>
        <div class="form-row">
            <select class="form-control col-6" name="curso" id="curso" required>
                <option value="none">Selecione o Curso</option>
                <option value="todos">Todos</option>
                <option value="35A">Ciência da Computação Noturno</option>
                <option value="65C">Ciência da Computação Integral</option>
                <option value="76A">Sistemas de Informação</option>
                <option value="65B">Engenharia Computacional</option>
            </select>
        </div>
        <hr>
    {/if}

    <p align="center" style="font-weight: 500; font-size: 20px; margin-top: 2%">Ao clicar no botao abaixo, serão atualizados os dados dos alunos e inseridos os novos!</p>

    <div align="center">
        <div class="alert alert-warning alert-dismissible fade show col-md-8" role="alert">
            <b>Atenção!</b> Efetue um backup do banco de dados antes de atualizar os dados!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item">
            <a id="a" href="{path_for name="adminDataLoad"}?curso=" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" onClick="showLoader();">Atualizar dados de alunos</a>
        </li>
        <li class="nav-item">
            <a href="{path_for name="gradeLoadAction"}" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Cadastrar nova grade</a>
        </li>
    </ul>

    <div align="center">
        <img id="loader" style="display:none;" src="{base_url}/img/carregando.gif"/>
    </div>

{/block}
{block name=javascript}
<script type="text/javascript">
    function showLoader() {
        document.getElementById("a").href += document.getElementById("curso").value; 
        document.getElementById("loader").style.display = 'block';
        for (let e of document.getElementsByTagName("a")) { 
            e.classList.remove('active');
            e.classList.add('disabled');
        }
    }

</script>
{/block}