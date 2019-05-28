{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Tópicos na categoria {$categoria->getNome()}</h3>
    <table class="table table-hover tabela-forum" align="center">
        <thead>
        <tr>
            <th>Tópico</th>
            <th>Criação</th>
        </tr>
        </thead>
        {foreach $topicsFull as $topic}
            <tr>
                <td class="leftpart">
                    <a href="topic.php?id={$topic->getIdentifier()}">{$topic->getAssunto()}</a><br>
                </td>
                <td class="rightpart">
                    {$topic->getData()}
                </td>
            </tr>
        {/foreach}
    </table>

    <div class="row container">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a href="{path_for name="novoTopico" data['id' => $categoria->getIdentifier()]}" class="btn btn-primary active" role="button" aria-pressed="true">Novo tópico</a>
            </li>
        </ul>
    </div>
{/block}