{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Fórum</h3>
    <h5 class="text-center">Escolha uma categoria para visualizar seus tópicos ou criar um novo!</h5>

    <table class="table table-hover tabela-topicos" align="center">
        <thead>
        <tr>
            <th>Categorias</th>
            <th>Número de Tópicos</th>
        </tr>
        </thead>
        {foreach $categoriesFull as $category}
            <tr>
                <td class="leftpart">
                    <a href="{path_for name="showCategory" data=["id" => $category->getIdentifier()]}">{$category->getNome()}</a><br>{$category->getDescricao()}
                </td>
                <td >
                    {$topicosPorCategoria[$category->getIdentifier()]}
                </td>
            </tr>
        {/foreach}
    </table>

    <div class="row container">
        <ul class="nav nav-pills nav-fill">
            {if $user->isAdmin()}
                <li class="nav-item">
                    <a href="{path_for name="novaCategoria"}" class="btn btn-primary active" role="button" aria-pressed="true">Nova categoria</a>
                </li>
            {/if}
            {*<li class="nav-item">*}
                {*<a href="{path_for name="novoTopico"}" class="btn btn-primary active" role="button" aria-pressed="true">Novo tópico</a>*}
            {*</li>*}
        </ul>
    </div>
{/block}