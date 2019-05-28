{extends 'layout.tpl'}
{block name=content}
    <h4 align="center">Criar novo tópico</h4>

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
            Tópico criado com sucesso!<br/>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    <form method="post">
        <div class="form-row">
            <div class="col-8">
                <label>Assunto</label>
                <input type="text" name="topic_subject" class="form-control" id="topic_subject"><br>
            </div>
        </div>
        <div class="form-row">
            <div class="col-8">
                <label>Mensagem</label><br>
                <textarea name="post_content"  id="post_content" cols="100" rows="7" placeholder="Máximo 200 caracteres"></textarea>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Criar</button>
    </form>
{/block}