{extends 'layout.tpl'}
{block name=content}

    <table style="margin-top: 4%" class="table table-hover">
        <thead class="thead-light">
        <tr>
            <th scope="col">Matrícula</th>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col">Nº Acessos</th>
        </tr>
        </thead>
        <tbody>
        {foreach $alunos as $aluno}
            <tr>
                <td>{$aluno['matricula']}</td>
                <td>{$aluno['nome']}</td>
                <td>{$aluno['email']}</td>
                <td>0</td>
            </tr>
        {/foreach}
    </table>

{/block}