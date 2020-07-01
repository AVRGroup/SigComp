{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Editar disciplina</h3>


    <form style="margin: 20px" action="{base_url}/admin/update-disciplina/{$disciplina->getId()}" method="post">
        <div class="form-group">
            <label for="codigo"><b>Codigo:</b></label>
            <input type="text" name="codigo" class="form-control col-2" id="codigo" value="{$disciplina->getCodigo()}" >
        </div>

        <div class="form-group mt-4">
            <label for="nome"><b>Nome:</b></label>
            <input type="text" name="nome" class="form-control col-6" id="nome" value="{$disciplina->getNome()}" >
        </div>

        <div class="form-group mt-4">
            <label for="carga"><b>Carga Horária:</b></label>
            <input type="number" name="carga" class="form-control col-1" id="carga" value="{$disciplina->getCarga()}" >
        </div>

        <button type="submit" class="btn btn-primary mt-4">Editar</button>
    </form>
{/block}