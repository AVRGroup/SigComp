{extends 'layout.tpl'}
{block name=content}
    <div class="card-topico">
        <div class="conteudo-topico">
            <h5 class="titulo-topico">{$topico->getAssunto()}</h5>

            <p>{$topico->getConteudo()}</p>
        </div>

    </div>


    <form method="post">
        <div id="resposta-topico"></div>
        <input type="hidden" id="post-content" name="post_content">
    </form>




{/block}

{block name=javascript}
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script type="text/javascript">
        var quill = new Quill('#resposta-topico', {
            theme: 'snow'
        });

    </script>
{/block}