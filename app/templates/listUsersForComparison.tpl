{extends 'layout.tpl'}
{block name=content}
    <h4 class="text-center mb-4">Selecione até 5 alunos para comparação</h4>

    {if ! $haPesquisaPorCursoEspecifico}
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Alunos de cursos diferentes possuem grades distintas. A comparação neste caso é menos precisa.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    {if $usuarioLogado->isCoordenador()}
        <select class="form-control col-3" name="curso" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value)">
            <option value="{base_url}/admin/comparar-usuarios?curso=curso{if $pesquisaNome}&nome={$pesquisaNome}  {/if}"
                    {if $haPesquisaPorCursoEspecifico} selected {/if}>
                Alunos do curso (padrão)
            </option>

            <option value="{base_url}/admin/comparar-usuarios?curso=todos{if $pesquisaNome}&nome={$pesquisaNome}  {/if}"
                    {if ! $haPesquisaPorCursoEspecifico} selected {/if}>
                Todos os alunos
            </option>
        </select>
    {/if}

    <div class="row mt-3" style="margin-left: 0">
        <input  type="text" class="form-control col-4" name="nome" id="pesquisa-nome"
                placeholder="Digite o nome ou a matrícula do aluno" {if $pesquisaNome} value="{$pesquisaNome}" {/if}
                onkeyup="updateUrl(this, event)"
        >

        <button class="btn btn-primary col-1" style="margin-left: 10px" onclick="window.location.href = window.location.href">Pesquisar</button>
    </div>

    {if isset($error)}
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>{$error}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    <form action="{base_url}/admin/ver-comparacao" method="post">
        <button class="btn btn-success mt-4">Comparar</button>
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

{block name=javascript}
    <script type="application/javascript">
        function updateUrl(input, event) {
            const nome = document.getElementById(input.id).value
            const urlAtual = window.location.href

            const queryParameters = urlAtual.split('?')[1]
            let newUrl = ""

            if (queryParameters) {
                if (queryParameters.includes('curso') && queryParameters.includes('nome')) {
                    newUrl = '?' + queryParameters.split('&')[0] //pega a parte do 'curso=...'
                    newUrl += '&nome=' + nome

                } else if (queryParameters.includes('curso')) {
                    newUrl += '?' + queryParameters + '&nome=' + nome

                } else if (queryParameters.includes('nome')) {
                    newUrl = '?nome=' + nome
                }
            } else {
                newUrl = '?nome=' + nome
            }

            window.history.replaceState('', '', 'comparar-usuarios' + newUrl)
            
            if (event.key === 'Enter') {
                window.location.href = window.location.href
            }
        }
    </script>
{/block}