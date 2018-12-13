{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Fórum</h3>

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