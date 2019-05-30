{extends 'layout.tpl'}
{block name=content}

    <!--suppress ALL -->
    <h3 class="text-center mb-4">Gerenciar Usuários</h3>

    <form class="form-row" method="post">
        <input id="pesquisa" name="pesquisa" type="text" class="form-control col-md-8" placeholder="Digite o nome ou a matrícula">
        <button style="margin-left: 1%" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
    </form>

    <table style="margin-top: 4%" id="tabela" class="table table-hover">
        <thead class="thead-light">
        <tr>
            <th scope="col">Matrícula</th>
            <th scope="col">Nome</th>
            <th scope="col">IRA</th>
            <th scope="col" width="20%">Email</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        {foreach $users as $user}
            {if in_array($user['nome'], ['ADMINISTRADOR', "BOLSISTA"])  }
                {continue}
            {/if}
            <tr>
                <td>{$user['matricula']}</td>
                <td>{$user['nome']}</td>
                <td>{number_format($user['ira'], 2)}</td>
                <td>{$user['email']}</td>
                <td><a href="{path_for name="adminUser" data=["id" => $user['id']]}"><span class="fas fa-eye" aria-hidden="true"></span></a></td>
            </tr>
        {foreachelse}
            <tr>
                <td scope="row" colspan="4" class="text-center">Nenhum usuário encontrado!</td>
            </tr>
        {/foreach}
        </tbody>
    </table>

{/block}



