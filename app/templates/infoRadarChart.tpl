{extends 'layout.tpl'}
{block name=content}
    <div class="container">
        <h3 class="text-center">Informações sobre o Gráfico</h3>
        <a href="{path_for name="home"}" class="btn btn-primary">Tela inicial</a>
        <p class="mt-4 mb-4">Essa tabela mostra quais disciplinas correspondem a quais grupos. Toda disciplina eletiva ou optativa pertence ao grupo "Multidisplinaridade"</p>

        <table id="tabela" class="table table-hover">
            <thead class="thead-light">
                <tr style="font-size: 13px;">
                    <th scope="col">Nome ↑↓</th>
                    <th scope="col">Grupo ↑↓</th>
                </tr>
            </thead>

            <tbody>
                {foreach $disciplinas as $disciplina}
                    <tr>
                        <td>{$disciplina->getNome()}</td>
                        <td>{$disciplina->getGrupo()->getNome()}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
{/block}