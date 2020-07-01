{extends 'layout.tpl'}

{block name=content}
    <h3 class="text-center">Criar Novo Grupo</h3>
    <a href="{base_url}/admin/ver-grupo" class="btn btn-primary mb-4">Voltar</a>

    <p>Grupo já cadastrados para seu curso:</p>
    <ul>
        {foreach $grupos as $grupo}
            <li>{$grupo->getNome()}</li>
        {foreachelse}
            <p>Ainda não há grupos cadastrados</p>
        {/foreach}
    </ul>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <b>Atenção!</b> Só é possível cadastrar 4 grupos para um curso. O 5º grupo sempre será reservado para as disciplinas eletivas e optativas.
        Seu nome padrão é "Multidisciplinaridade", mas pode ser editado.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="form-group">
        <form action="{base_url}/admin/store-grupo" method="post">
            <label for="nome" class="mt-4"><strong>Nome do grupo:</strong></label>
            <input type="text" class="form-control col-sm-6" name="nome" id="nome">

            <button class="btn btn-success mt-4">Criar grupo</button>
        </form>
    </div>
{/block}