{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Categorias</h3>
    <table class="table table-hover" align="center">
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Último tópico</th>
            </tr>
        </thead>
        {foreach $categoriesFull as $category}
            <tr>
                <td class="leftpart">
                    <a href="category.php?id">{$category->getNome()}</a><br>{$category->getDescricao()}
                </td>
                <td class="rightpart">
                    <a href="topic.php?id=">Topic subject</a>
                </td>
            </tr>
        {/foreach}
    </table>

    <div class="row container">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a href="{path_for name="novaCategoria"}" class="btn btn-primary active" role="button" aria-pressed="true">Nova categoria</a>
            </li>
        </ul>
    </div>
{/block}