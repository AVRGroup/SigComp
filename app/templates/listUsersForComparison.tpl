{extends 'layout.tpl'}
{block name=content}
    <h4 class="text-center">Selecione 2 alunos para comparação</h4>

    {if isset($error)}
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>{$error}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    <form action="{base_url}/admin/ver-comparacao" method="post">
        <button class="btn btn-success">Comparar</button>
        <table style="margin-top: 4%" id="tabela" class="table table-hover">
            <thead class="thead-light">
            <tr style="font-size: 13px;">
                <th scope="col">Matrícula ↑↓</th>
                <th scope="col">Nome ↑↓</th>
                <th scope="col">Selecione 2 alunos</th>
            </tr>
            </thead>
            <tbody>
            {foreach $users as $user}
                {if $user['tipo'] == 0}
                    <tr>
                        <td>{$user['matricula']}</td>
                        <td><a href="{path_for name="adminUser" data=["id" => $user['id']]}">{$user['nome']}</a></td>
                        <td><input type="checkbox" name="user[]" value="{$user['id']}"></td>
                    </tr>
                {/if}

                {foreachelse}
                <tr>
                    <td scope="row" colspan="4" class="text-center">Nenhum usuário encontrado!</td>
                </tr>
            {/foreach}
            </tbody>
        </table>

        <button class="btn btn-success">Comparar</button>

    </form>


{/block}
