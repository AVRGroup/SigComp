{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Home</h3>
    <h3 class="text-center">Bem vindo {$loggedUser->getNome()}!</h3>
    <h4>Notas dos usuários</h4>
    <ul>
        {foreach $usuarioFull->getNotas() as $nota}
            <li>{$nota->getDisciplina()->getCodigo()} -> {$nota->getValor()} </li>
        {/foreach}
    </ul>
{/block}