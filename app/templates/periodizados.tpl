{extends 'layout.tpl'}
{block name=content}
    <!--suppress ALL -->
    <h3 class="text-center mb-4">Alunos Periodizados</h3>

    <table style="margin-top: 4%" id="tabela" class="table table-hover">
        <thead class="thead-light">
        <tr style="font-size: 13px;">
            <th scope="col">Matrícula ↑↓</th>
            <th scope="col">Nome ↑↓</th>
            <th scope="col">IRA ↑↓</th>
            <th scope="col">Email ↑↓</th>
            <th scope="col">Grade</th>
        </tr>
        </thead>
        <tbody>
        {foreach $users as $user}
            <tr>
                <td>{$user['matricula']}</td>
                <td><a href="{path_for name="adminUser" data=["id" => $user['id']]}">{$user['nome']}</a></td>
                <td>{number_format($user['ira'], 2)}</td>
                <td>{$user['email']}</td>
                <td>{$user['grade']}</td>
            </tr>
            {foreachelse}
            <tr>
                <td scope="row" colspan="4" class="text-center">Nenhum usuário encontrado!</td>
            </tr>
        {/foreach}
        </tbody>
    </table>

{/block}



