{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Tópicos na categoria {$categoria->getNome()}</h3>
    <table class="table table-hover tabela-forum" align="center">
        <thead>
        <tr>
            <th>Tópico</th>
            <th>Autor</th>
            <th>Criação</th>
        </tr>
        </thead>
        {foreach $topicsFull as $topic}
            <tr>
                <td class="leftpart">
                    <a href="{base_url}/forum/topico/{$topic->getId()}">{$topic->getAssunto()}</a><br>
                </td>
                <td>
                    {$topic->getUsuario()->getNomeAbreviado()}
                </td>
                <td class="rightpart">
                    {date_format(date_create($topic->getData()), 'd/m/y ')}
                </td>
            </tr>
        {/foreach}
    </table>

    <div class="row container">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a href="{path_for name="novoTopico" data=['id' => $categoria->getIdentifier()]}" class="btn btn-primary active" role="button" aria-pressed="true">Novo tópico</a>
            </li>
        </ul>
    </div>
{/block}