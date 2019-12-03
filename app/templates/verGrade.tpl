{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Editar Grade</h3>

    <div class="text-center mt-4">
        <a href="" class="btn btn-primary btn-lg">Criar Novo Grupo</a>
    </div>

    <table style="margin-top: 4%" id="tabela" class="table table-hover">
        <thead class="thead-light">
        <tr style="font-size: 13px;">
            <th scope="col">Codigo ↑↓</th>
            <th scope="col">Nome ↑↓</th>
            <th scope="col">Categoria ↑↓</th>
        </tr>
        </thead>
        <tbody>
        {foreach $disciplinas as $disciplina}
            <tr>
                <td>{$disciplina->getCodigo()}</td>
                <td>{$disciplina->getNome()}</td>
                <td>
                    <select class="form-control" name="grupo" id="grupo">
                        <option value="1">Teste</option>
                    </select>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{/block}