{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center mb-4">Gerenciar Usuários</h3>
    <table class="table table-hover">
        <thead class="thead-light">
        <tr>
            <th scope="col">Matrícula</th>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        {foreach $users as $user}
            <tr>
                <td>{$user->getMatricula()}</td>
                <td>{$user->getNome()}</td>
                <td>{$user->getEmail()}</td>
                <td><a href="{path_for name="adminUser" data=["id" => $user->getId()]}"><span class="far fa-edit" aria-hidden="true"></span></a></td>
            </tr>
        {foreachelse}
            <tr>
                <td scope="row" colspan="4" class="text-center">Nenhum usuário encontrado!</td>
            </tr>
        {/foreach}
    </table>
{/block}
