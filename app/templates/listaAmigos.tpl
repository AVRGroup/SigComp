{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Lista de Amigos</h3>
    <hr>

        {foreach $amigos as $indice => $amigo}
            <div class="row">
                <div class="col-3">
                    <img src="{base_url}/{if $amigo['foto']}upload/{$amigo['foto']}{else}img/silhueta.jpg{/if}"
                         class="img-thumbnail" alt="{$amigo['nome']}" width="190" height="190" style="margin-top: 50px">
                </div>
                <div class="col-9">
                    <h5 class="text-center">{$amigo['nome']}</h5>
                    <a href="{path_for name="visualizarAmigo" data=["id" => $amigo['id_amigo']]}"><p class="text-center" style="margin-bottom: 0; font-size: 14px">visualizar perfil</p></a>

                    <p class="mb-0 mt-3 nome-atributos"><b>Experiência:</b> {$amigo['experiencia']}xp</p>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar" role="progressbar" style="width: {(100 * $amigo['experiencia'])/($amigo['experiencia'] +500 ) }%;">{((100 * $amigo['experiencia'])/($amigo['experiencia'] +500 ))|string_format:"%.2f"}%</div>
                    </div>

                    <div class="row medalha-amigos">
                        {foreach $medalhas[$indice] as $medalha}
                            {if sizeof($medalhas[$indice]) > 1}
                                <div class="img-thumbnail-amigo altura-medalha-amigo col-4" style="max-width: 80px; margin-right: 5px">
                                    <img src="{base_url}/img/{$medalha['imagem']}" class="img-fluid">
                                </div>
                            {else}
                                <h6 style="margin-left: 130px; margin-top: 30px">Esse amigo ainda não possui medalhas</h6>
                            {/if}
                        {/foreach}
                    </div>


                </div>
            </div>
            <hr>
        {/foreach}



{/block}