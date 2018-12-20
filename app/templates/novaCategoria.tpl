{extends 'layout.tpl'}
{block name=content}

    <h4 align="center">Criar nova categoria</h4>

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
            {$success}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    <form method="post">
        <div class="form-row">
            <div class="col-8">
                <label>Nome da categoria</label>
                <input type="text" name="nomeCategoria" class="form-control" id="nomeCategoria">
            </div>
        </div>
        <div class="form-row">
            <div class="col-8">
                <label>Descrição da categoria</label><br>
                <textarea name="descricaoCategoria"  id="descricaoCategoria" cols="50" rows="7" placeholder="Máximo 50 caracteres"></textarea>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Criar</button>
    </form>
{/block}