{extends 'layout.tpl'}
{block name=content}
    <div style="padding: 20px;">
        <div class="text-center" style="margin-top: 20px">
            {if !$usuario->isAluno()}
                <div style="margin-bottom: 5%"><b>Link para enviar no email:</b> {base_url}/login?oportunidade={$oportunidade->getId()}</div>
            {/if}
        </div>
    </div>
{/block}