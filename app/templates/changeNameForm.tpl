{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Trocar nome do grupo</h3>
    <form action="{base_url}/admin/change-name-action/{$grupo->getId()}" method="post">
        <label class="label mt-4" ><b>Nome:</b></label>
        <input class="form-control col-6" type="text" name="nome" value="{$grupo->getNome()}">

        <button class="btn btn-primary mt-4">Salvar</button>
    </form>


{/block}