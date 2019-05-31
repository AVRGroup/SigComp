{extends 'layout.tpl'}

{block name=content}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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

        <div id="editor"></div>

        <input type="hidden" id="post-content" name="post_content">

        <button class="btn btn-primary" type="submit" onclick="addContentToInput()" style="margin-top: 20px">Criar</button>
    </form>


    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });


        function addContentToInput() {
            var html = document.querySelector('#editor').children[0].innerHTML;
            document.getElementById("post-content").value = html;
        }

    </script>
{/block}
