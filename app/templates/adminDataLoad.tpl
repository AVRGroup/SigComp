{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Carga de Dados</h3>
    {if isset($error)}
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {$error}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}
    {if isset($success)}
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Carga efetuada com sucesso!<br/>
            {$affectedData['disciplinasAdded']} Disciplina(s) adicionada(s) <br/>
            {$affectedData['usuariosAdded']} Usuário(s) adicionado(s) <br/>
            {$affectedData['usuariosUpdated']} Usuário(s) Atualizado(s)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <b>Atenção!</b> Efetue um backup do banco dados antes de enviar uma nova carga!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="data" name="data">
                <label class="custom-file-label" for="data">Selecionar .CSV</label>
            </div>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Enviar</button>
            </div>
        </div>
    </form>
{/block}
