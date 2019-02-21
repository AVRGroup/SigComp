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
                    <a href="{path_for name="visualizarAmigo" data=["id" => $amigo['id']]}"><p class="text-center" style="margin-bottom: 0; font-size: 14px">visualizar perfil</p></a>

                    <p class="mb-0 mt-3 nome-atributos"><b>Experiência:</b> {$amigo['experiencia']}xp</p>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar" role="progressbar" style="width: {(100 * $amigo['experiencia'])/($amigo['experiencia'] +500 ) }%;">{((100 * $amigo['experiencia'])/($amigo['experiencia'] +500 ))|string_format:"%.2f"}%</div>
                    </div>

                    <div class="row medalha-amigos">

                        {foreach $medalhas[$indice] as $indiceMedalha => $medalha}
                            <div class="img-thumbnail altura-medalha-amigo col-4" style="max-width: 100px; margin-right: 30px">
                                <img src="{base_url}/img/{$medalha['imagem']}" class="img-fluid">
                                <div class="caption">
                                    <p class="text-center"><small class="legenda-imagem">{$medalha['nome']}</small></p>
                                </div>
                            </div>
                            {if $indiceMedalha == 2}
                                {break}
                            {/if}
                        {/foreach}
                    </div>


                </div>
            </div>
            <hr>
        {/foreach}



{/block}