{extends 'layout.tpl'}
{block name=content}
    <h4 class="text-center">Selecione até 5 alunos para comparação</h4>

    <form method="get" class="mb-5 mt-5">
        <div class="form-row col-12">
            <input type="text" class="form-control col-4" name="nome" placeholder="Digite o nome ou a matrícula do aluno">

            {if $usuarioLogado->isCoordenador()}
                <select class="form-control col-3 ml-2" name="curso">
                    <option value="curso" {if $haPesquisaPorCursoEspecifico} selected {/if}>Alunos do curso (padrão)</option>
                    <option value="todos" {if ! $haPesquisaPorCursoEspecifico} selected {/if}>Todos os alunos</option>
                </select>
            {/if}

        </div>

        <button class="btn btn-primary mt-2" style="margin-left: 10px">Pesquisar</button>
    </form>

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
                <th scope="col">Selecione até 5 alunos</th>
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
