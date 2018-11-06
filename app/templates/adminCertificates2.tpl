{extends 'layout.tpl'}
{block name=content}
    <h1 class="text-center">Gerenciar Certificados</h1>
    <hr>
    {foreach $certificates as $certificate}
    <div class="row">
        <div class="col-8">
            <a href="{base_url}/upload/{$certificate->getNome()}" target="_blank">
                <img class="card-img-top img-certificado" src="{base_url}/upload/{$certificate->getNome()}">
            </a>
        </div>
    </div>

    <hr>
    {/foreach}
{/block}