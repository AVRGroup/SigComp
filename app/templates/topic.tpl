{extends 'layout.tpl'}
{block name=content}

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <div class="card-topico">
            <h5 class="assunto-topico">{$topico->getAssunto()}</h5>

            {$topico->getConteudo()}

    </div>

    <div class="respostas">
        {foreach $respostas as $resposta}
            <div class="card-topico resposta">
                {$resposta->getConteudo()}
            </div>
        {/foreach}
    </div>

    <hr style="clear: both">

    <div>
        <h5>Contribuia com a discussão:</h5>

        <form action="{base_url}/forum/topico/responder" method="post" style="margin-top: 20px">
            <div id="resposta-topico"></div>

            <input type="hidden" id="resposta" name="resposta">
            <input type="hidden" name="id_topico" value={$topico->getId()}>
            <input type="hidden" name="id_usuario" value={$loggedUser->getId()}>

            <button class="btn btn-primary" type="submit" onclick="addContentToInput()" style="margin-top: 20px">Responder</button>
        </form>
    </div>


    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script type="text/javascript">
        new Quill('#resposta-topico', {
            theme: 'snow'
        });

        function addContentToInput() {
            var html = document.querySelector('#resposta-topico').children[0].innerHTML;
            document.getElementById("resposta").value = html;
        }
    </script>

{/block}
