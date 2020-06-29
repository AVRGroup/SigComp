{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Carga de Dados</h3>

    <div align="center">
        <div class="alert alert-warning alert-dismissible fade show col-md-8" role="alert">
            <b>Atenção!</b> Efetue um backup do banco de dados antes de clicar no botão abaixo!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <div align="center" >
        <a href="{path_for name="adminDataLoad"}" style="margin-top: 4%; width: 300px; height: 45px" class="btn btn-outline-dark" type="submit">Atualizar dados</a>  
    </div>

{/block}