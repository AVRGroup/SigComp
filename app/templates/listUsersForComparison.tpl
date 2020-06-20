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
                onkeyup="atualizaUrlComNome(this, event)"
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

        <h5 class="mt-4">Alunos Selecionados:</h5>
        <div class="usuarios-selecionados-wrapper">

        </div>

        <button class="btn btn-success mt-4" onclick="removeAlunosSelecionadosDoLocalStorage()">Comparar</button>

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
                        <td><input type="checkbox" class="checkbox-aluno" id="checkbox-aluno-{$user['id']}" value="{$user['id']}" data-nome="{$user['nome']}" onchange="salvarAlunoSelecionado(this)"></td>
                    </tr>
                {/if}

                {foreachelse}
                <tr>
                    <td scope="row" colspan="4" class="text-center">Nenhum usuário encontrado!</td>
                </tr>
            {/foreach}
            </tbody>
        </table>

        <button class="btn btn-success" onclick="removeAlunosSelecionadosDoLocalStorage()">Comparar</button>

    </form>
{/block}

{block name=javascript}
    <script type="application/javascript">
        window.onload = function () {
            let alunosSelecionados = localStorage.getItem('alunosSelecionados')

            const todosUsuarios = JSON.parse('{json_encode($todosUsuarios)}')

            if (! alunosSelecionados) {
                return
            }

            alunosSelecionados = alunosSelecionados.split(',')

            for(let idAluno of alunosSelecionados) {
                const checkboxAluno = $('#checkbox-aluno-' + idAluno)
                if (checkboxAluno) {
                    checkboxAluno.prop("checked", true)
                }

                let aluno = todosUsuarios.find(aluno => aluno.id === idAluno)

                const htmlListaAluno = getHtmlListaAluno(aluno.nome, idAluno)

                $('.usuarios-selecionados-wrapper').append(htmlListaAluno)
            }

        }



        function atualizaUrlComNome(input, event) {
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

        //////////////////
        //////////////////
        //////////////////

        let alunosSelecionados = localStorage.getItem('alunosSelecionados')

        if (alunosSelecionados) {
            alunosSelecionados = alunosSelecionados.split(',')
        }

        function salvarAlunoSelecionado(input) {
            if (input.checked) {
                adicionaAlunoDoArray(input.value, input.dataset.nome)
            } else {
                removeAlunoDoArray(input.value);
            }
        }


        function adicionaAlunoDoArray(idAluno, nomeAluno) {
            alunosSelecionados.push(idAluno);

            const htmlListaAluno = getHtmlListaAluno(nomeAluno, idAluno)
            $('.usuarios-selecionados-wrapper').append(htmlListaAluno)

            localStorage.setItem('alunosSelecionados', alunosSelecionados.toString())
        }


        function removeAlunoDoArray(idAluno, isCliqueBotao = false) {
            $('#lista-alunos-selecionados-aluno-' + idAluno).remove()

            //se o clique ocorreu no "×" do nome do aluno em vez da checkbox
            if (isCliqueBotao) {
                const checkboxAluno = $('#checkbox-aluno-' + idAluno)
                checkboxAluno.prop("checked", false)
            }


            idAluno = idAluno.toString()

            for (let index in alunosSelecionados) {
                if (alunosSelecionados[index] === idAluno) {
                    alunosSelecionados.splice(index, 1)
                }
            }

            localStorage.setItem('alunosSelecionados', alunosSelecionados.toString())
        }

        function removeAlunosSelecionadosDoLocalStorage() {
            localStorage.removeItem('alunosSelecionados')
        }

        function getHtmlListaAluno(nome, id) {
            return "<div id='lista-alunos-selecionados-aluno-"+ id+"'>" +
                "<span>" + nome + "</span>" +
                "<span style='color: red; cursor:pointer; font-size: 22px' onclick='removeAlunoDoArray("+ id +", true)'> &times; </span>" +
                "<input type='hidden' name='user[]' value='" + id + "'>" +
            "</div>"
        }
    </script>
{/block}