{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Home</h3>
    <h3 class="text-center">Bem vindo {$loggedUser->getNome()}!</h3>
{/block}