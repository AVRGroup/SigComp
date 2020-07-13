{extends 'layout.tpl'}
{block name=content}  
    <h3 class="text-center">Carga de Dados</h3>
    <p align="center" style="font-weight: 500; font-size: 20px; margin-top: 2%">Ao clicar no botao abaixo, serão atualizados os dados dos alunos e inseridos os novos!</p>

    <div align="center">
        <div class="alert alert-warning alert-dismissible fade show col-md-8" role="alert">
            <b>Atenção!</b> Efetue um backup do banco de dados antes de atualizar!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    
    <div class="row text-center">
        <div class="col-md-6" >
            <a href="{path_for name="adminDataLoad"}" style="margin-top: 3%; width: 300px; height: 45px; " class="btn btn-outline-primary" type="submit"><span style="font-size: 20px">Atualizar dados</span></a>  
        </div>
        <div class="col-md-6" >
            <a href="{path_for name="gradeLoadAction"}" style="margin-top: 3%; width: 300px; height: 45px; " class="btn btn-outline-dark" type="submit"><span style="font-size: 20px">Atualizar Grade</span></a>  
        </div>
    </div>

{/block}