{extends 'layout.tpl'}
{block name=content}

    <h4 align="center">Criar novo tópico</h4>

    <form method="post">
        <div class="form-row">
            <div class="col-8">
                <label>Assunto</label>
                <input type="text" name="topic_subject" class="form-control" id="topic_subject"><br>
                <label>Categoria</label>
                <select name="topic_cat">
                    {foreach $categoriesFull as $category}
                        <option value="{$category->getIdentifier()}">{$category->getNome()}</option>
                    {/foreach}
                </select>
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