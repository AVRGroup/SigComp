{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Carga de Dados</h3>
    {if isset($error)}
    <div align="center">
        <div class="alert alert-danger alert-dismissible fade show col-md-8" role="alert">
            {$error}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    {/if}
    {if isset($success)}
        <div align="center">
            <div class="alert alert-success alert-dismissible fade show col-md-8" role="alert">
                Carga efetuada com sucesso!<br/>
                {$affectedData['disciplinasAdded']} Disciplina(s) adicionada(s) <br/>
                {$affectedData['usuariosAdded']} Usuário(s) adicionado(s) <br/>
                {$affectedData['usuariosUpdated']} Usuário(s) Atualizado(s)
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    {/if}

    <form method="POST" action="{path_for name="home"}">  
        <nav aria-label="navigation" class="pagination justify-content-center">
            <button style="margin-top: 2%; width: 300px; height: 45px" class="btn btn-primary" type="submit">Confirmar</button>  
        </nav>
    </form>

{/block}
