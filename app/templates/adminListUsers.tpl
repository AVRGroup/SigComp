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
        <tr style="font-size: 13px;">
            <th scope="col">Matrícula ↑↓</th>
            <th scope="col">Nome ↑↓</th>
            <th scope="col">IRA ↑↓</th>
            <th scope="col">Email ↑↓</th>
            <th scope="col">Concluido</th>
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
                <td><a href="{path_for name="adminUser" data=["id" => $user['id']]}">{$user['nome']}</a></td>
                <td>{number_format($user['ira'], 2)}</td>
                <td>{$user['email']}</td>
                <td><input type="checkbox" disabled {if $user['situacao'] == 1} checked {/if}></td>
                <td>
                    <button type="button" data-id="{$user['id']}" data-nome="{$user['nome']}" class="btn btn-primary concluir-modal" data-toggle="modal" data-target="#concluirCursoModal">
                        <i class="fa fa-trophy"></i>
                    </button>
                </td>
            </tr>
        {foreachelse}
            <tr>
                <td scope="row" colspan="4" class="text-center">Nenhum usuário encontrado!</td>
            </tr>
        {/foreach}
        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="concluirCursoModal" tabindex="-1" role="dialog" aria-labelledby="concluirCursoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="concluirCursoModalLabel">Marcar aluno como Concluído</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Você deseja atestar que o seguinte aluno concluiu o curso?</p>
                    <input type="text" class="form-control" id="nome-usuario" name="nome" disabled>
                </div>

                <div class="modal-footer" >
                    <form action="{base_url}/admin/set-concluido" method="post">
                        <input type="hidden" id="id-usuario" name="id" >
                        <button type="submit" class="btn btn-success">Continuar</button>
                    </form>

                    <form style="padding-bottom: 2rem;" action="{base_url}/admin/unset-concluido" method="post">
                        <input type="hidden" id="id-usuario" name="id" >
                        <button class="btn btn-link remover-concluido-link" >Revogar status de concluído</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
{/block}

{block name="javascript"}
    <script type="text/javascript">
        $(document).on("click", ".concluir-modal", function () {
            var id = $(this).data('id');
            var nome = $(this).data('nome');
            console.log(id);
            $(".modal-footer #id-usuario").val( id );
            $(".modal-body #nome-usuario").val( nome );
        });
    </script>
{/block}



