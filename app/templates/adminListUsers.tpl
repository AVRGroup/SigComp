{extends 'layout.tpl'}
{block name=content}
    {if $loggedUser->isProfessor()}
        <h3 class="text-center mb-4">Ver Alunos</h3>
    {else}
        <h3 class="text-center mb-4">Gerenciar Usuários</h3>
    {/if}

        <form method="get">
            <div class="form-row mx-auto">
                <input id="pesquisa" name="pesquisa" type="text" class="form-control col-md-6 mb-4 mx-auto" placeholder="Digite o nome ou a matrícula"
                {if $pesquisa} value="{$pesquisa}" {/if} >
            </div>

            <p align="center" style="font-size: 25px">Filtrar</p>
            {if $loggedUser->isAdmin()}
                <div class="form-row ">
                    <select class="form-control col-6 mx-auto" name="curso">
                        <option value="todos" {if $curso == 'todos'} selected {/if}>Todos</option>
                        <option value="35A" {if $curso == '35A'} selected {/if}>Ciência da Computação Noturno</option>
                        <option value="65C" {if $curso == '65C'} selected {/if}>Ciência da Computação Integral</option>
                        <option value="76A" {if $curso == '76A'} selected {/if}>Sistemas de Informação</option>
                        <option value="65B" {if $curso == '65B'} selected {/if}>Engenharia Computacional</option>
                    </select>
                </div>
            {/if}

            <div align="center" >
                <button type="submit"  class="btn btn-primary mt-4 col-md-4" ><i class="fa fa-search"></i> Pesquisar</button>
            </div>
        </form>

    <br>
    <hr>

    <table style="margin-top: 4%" id="tabela" class="table table-hover">
        <thead class="thead-light">
        <tr style="font-size: 13px;">
            <th scope="col">Matrícula ↑↓</th>
            <th scope="col">Nome ↑↓</th>
            <th scope="col">IRA ↑↓</th>
            <th scope="col">Email ↑↓</th>
            {if $loggedUser->isAdmin()}
                <th scope="col"></th>
            {/if}
        </tr>
        </thead>
        <tbody>
        {foreach $users as $user}
            {if $user['tipo'] == 0}
                <tr>
                    <td>{$user['matricula']}</td>
                    <td><a href="{path_for name="adminUser" data=["id" => $user['id']]}">{$user['nome']}</a></td>
                    <td>{number_format($user['ira'], 2)}</td>
                    <td>{$user['email']}</td>
                    {if $loggedUser->isAdmin()}
                        <td><a href="{base_url}/admin/impersonar-usuario/{$user['id']}"><i class="fa fa-eye"></i></a></td>
                    {/if}
                </tr>
            {/if}

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



