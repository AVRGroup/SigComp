{extends 'layout.tpl'}
{block name=content}  
    <h3 class="text-center">Carga de Dados</h3>
    <p align="center" style="font-weight: 500; font-size: 20px; margin-top: 2%">Ao clicar no botao abaixo, serão atualizados os dados dos alunos e inseridos os novos!</p>

    <div align="center">
        <div class="alert alert-warning alert-dismissible fade show col-md-8" role="alert">
            <b>Atenção!</b> Efetue um backup do banco de dados antes de atualizar os dados!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    
    <div align="center" >
        <a href="{path_for name="adminDataLoad"}" style="margin-top: 3%; width: 300px; height: 45px; " class="btn btn-outline-dark" type="submit"><span style="font-size: 20px">Atualizar dados</span></a>  
    </div>

{/block}