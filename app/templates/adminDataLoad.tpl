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

    {if $usuario->getCurso() == '65C' || $usuario->getCurso() == '65B'}
        {if $usuario->getCurso() == '65C'}
            {$mensagem = '(tanto o 65C quanto o 65AC).'}
        {/if}
        {if $usuario->getCurso() == '65B'}
            {$mensagem = '(tanto o 65B quanto o 65AB).'}
        {/if}
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <p>Lembrar de fazer o envio dos dois arquivos referentes aos alunos do curso {$mensagem}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    <div class="alert alert-warning alert-dismissible fade show" id="alerta" role="alert">
        <b>Atenção!</b> Essa operação demora alguns minutos
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="data" name="data">
                <label class="custom-file-label" for="data">Selecionar .CSV ou .XLSX</label>
            </div>

            <div class="input-group-append">
                <button class="btn btn-primary" id="enviar" type="submit">Enviar</button>
            </div>
        </div>
    </form>
{/block}
{block name=javascript}
    <script type="text/javascript">
        $('#alerta').hide()

        $('#enviar').click(function () {
            console.log('teste');
            $('#alerta').show()
        })
    </script>

{/block}