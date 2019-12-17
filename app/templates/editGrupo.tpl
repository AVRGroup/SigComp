{extends 'layout.tpl'}
{block name=content}

<div class="container">
    <h3 class="text-center mb-5">Editar Grupos</h3>
    <form action="{base_url}/admin/update-grupos" method="post">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr style="font-size: 13px;">
                    <th scope="col">Nome ↑↓</th>
                    <th scope="col">Posição ↑↓</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                {foreach $grupos as $index => $grupo}
                    <tr>
                        <td>{$grupo->getNome()}</td>
                        <td>
                            <select class="form-control" name="posicao-grupo-{$grupo->getId()}">
                                <option value="1" {if 1 == $grupo->getOrdem()} selected {/if}>1º</option>
                                <option value="2" {if 2 == $grupo->getOrdem()} selected {/if}>2º</option>
                                <option value="4" {if 4 == $grupo->getOrdem()} selected {/if}>4º</option>
                                <option value="5" {if 5 == $grupo->getOrdem()} selected {/if}>5º</option>
                            </select>
                        </td>
                        <td>
                            <a href="#" style="display: inline-block; margin-left: 10%"><i class="fa fa-trash" style="color: #fa5d49"></i></a>
                            <a href="{base_url}/admin/change-name/{$grupo->getId()}" style="display: inline-block; margin-left: 10%"><i class="fa fa-edit" style="color: #817dfa"></i></a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>

</div>

{/block}