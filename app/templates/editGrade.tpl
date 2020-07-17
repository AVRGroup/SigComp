{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Editar disciplina</h3>


    <form style="margin: 20px" action="{base_url}/admin/update-disciplina/{$disciplina->getId()}" method="post">
        <div align=" center">
            <div class="form-group">
                <label for="codigo"><b>Codigo:</b></label>
                <div align="center">
                    <input type="text" name="codigo" class="form-control col-2" id="codigo" value="{$disciplina->getCodigo()}" >
                </div>
            </div>

            <div class="form-group mt-4">
                <label for="nome"><b>Nome:</b></label>
                <div align="center">
                    <input type="text" name="nome" class="form-control col-6" id="nome" value="{$disciplina->getNome()}" >
                </div>
            </div>

            <div class="form-group mt-4">
                <label for="carga"><b>Carga Horária:</b></label>
                <div align="center">
                    <input type="number" name="carga" class="form-control col-1" id="carga" value="{$disciplina->getCarga()}" >
                </div>
            </div>
        </div>

    <br>
        <div align="center">
            <button type="submit" class="btn btn-primary mt-8" style="width: 300px">Editar</button>
        </div>
    </form>
{/block}