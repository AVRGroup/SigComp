{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Categorias</h3>
    <h5>Categoria - Descrição</h5>
    <ul>
        {foreach $categoriesFull as $category}
            <li>{$category->getNome()} - {$category->getDescricao()}</li>
        {/foreach}
    </ul>

    <div class="row container">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a href="{path_for name="novaCategoria"}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Nova categoria</a>
            </li>
        </ul>
    </div>
{/block}