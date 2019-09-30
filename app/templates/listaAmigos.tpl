{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Lista de Amigos</h3>
    <hr>
        {foreach $amigos as $indice => $amigo}
            <div class="row">
                <div align="center" class="col-sm-12 col-md-4">
                    <img src="{base_url}/{if $amigo['foto']}upload/{$amigo['foto']}{else}img/silhueta.jpg{/if}"
                         class="img-thumbnail" alt="{$amigo['nome']}" width="190" height="190" style="margin-top: 50px">
                </div>
                <div class="col-sm-12 col-md-8 mt-md-5">
                    <h5 class="text-center" style="margin-top: 30px">{$amigo['nome']}</h5>
                        <a href="{path_for name="visualizarAmigo" data=["id" => $amigo['id']]}">
                            <p class="text-center" style="margin-bottom: 0; font-size: 15px">Visualizar perfil</p>
                        </a>
                        <div class="text-center">
                            <p class="mb-2 mt-sm-3 mt-md-4 nome-atributos"><b>Experiência:</b> {$amigo['experiencia']}xp</p>
                        </div>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar" role="progressbar" style="width: {(100 * $amigo['experiencia'])/($amigo['experiencia'] +500 ) }%;">{((100 * $amigo['experiencia'])/($amigo['experiencia'] +500 ))|string_format:"%.2f"}%</div>
                    </div>
                </div>
                <hr>
                    <div class="row col-sm-12 mx-auto" style="margin-top: 20px; margin-bottom: 20px;">
                        {foreach $medalhas[$indice] as $medalha}
                            {if sizeof($medalhas[$indice]) > 1}
                                <div class="img-thumbnail-amigo altura-medalha-amigo" style="max-width: 90px; max-height: 110px; margin-right: 3px; margin-left: 2px">
                                    <img src="{base_url}/img/{$medalha['imagem']}" class="img-fluid">
                                </div>
                            {else}
                                <h6 style="margin-left: 130px; margin-top: 30px">Esse amigo ainda não possui medalhas</h6>
                            {/if}
                        {/foreach}
                    </div>
            </div>
            <hr>
        {/foreach}



{/block}