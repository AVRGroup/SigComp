{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Profiles</h3><br/><br/>
    <table class="table table-striped table-hover">
        <tr>
            <th>Perfil Disponível</th>
            <th>Curso</th>
            <th></th>
        </tr>
        {foreach $profiles as $profile}
            {if $profile['id'] == $loggedUser->getId()}
            <tr>
                <td><b>{$profile['matricula']}</b></td>
                <td><b>{$profile['curso']}</b></td>
                <td class="text-center" width="15%"></td>
            </tr>
            {else}
                <tr>
                    <td>{$profile['matricula']}</td>
                    <td>{$profile['curso']}</td>
                    <td class="text-center" width="15%"><a class="btn btn-primary" href="#" role="button">Trocar</a></td>
                </tr>
            {/if}
        {/foreach}

    </table>
    <br/><br/>
{/block}
