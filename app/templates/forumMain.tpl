{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Fórum</h3>

    <h5 class="text-center">Categorias</h5>
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
                    <a href="topic.php?id=">Último tópico</a>
                </td>
            </tr>
        {/foreach}
    </table>

    <div class="row container">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a href="{path_for name="novaCategoria"}" class="btn btn-primary active" role="button" aria-pressed="true">Nova categoria</a>
            </li>
            <li class="nav-item">
                <a href="{path_for name="novoTopico"}" class="btn btn-primary active" role="button" aria-pressed="true">Novo tópico</a>
            </li>
        </ul>
    </div>
{/block}