{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Painel Coordenador </h2>
    <hr>
    {if isset($incompleto)}
        <div align="center" style="margin-bottom: 4%;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {$incompleto}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    {/if}
    
    {if isset($completo)}
        <div align="center" style="margin-bottom: 1%;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {$completo}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
        </div>
    {/if}

    {if isset($store)}
    <div align="center">
        <div class="alert alert-warning alert-dismissible fade show col-md-8" role="alert">
            <b>Atenção!</b> Você deve selecionar ao menos um professor em cada período!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    {/if}

    <div>
        {if isset($index)}
        <form method="POST" action="{base_url}/admin/store-painel-coordenador">

            <input type="hidden" name="periodoCorrente" value="{$periodoCorrente}">
            <input type="hidden" name="digito" value="{$digito}">
            {foreach $periodos as $p}
                <input type="hidden" name="periodosArray[]" value="{$p}">
            {/foreach}

                <h4 align="center" style="color: blue"> Período corrente: {$periodoCorrente} - {$digito}</h4>

                <h5 align="center" style="font-style: italic; margin-top: 2%; margin-bottom: 2%">Selecione abaixo os períodos que deseja utilizar na avaliação</h5>

                {foreach $periodos as $per}
                    <div align="center" style="margin-top: 1%">
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="customRadio_{$per}" id="periodo_{$per}" value="{$per}">
                            <label class="custom-control-label" for="periodo_{$per}"><span style="font-size: 20px">Período: {$per}</span></label>
                        </div>
                    </div>
                {/foreach}

                <div align="center">
                    <button class="btn btn-outline-primary" style="width: 200px; margin-top: 3%" type="submit"> Próximo </button>
                </div>
        </form>

        {elseif isset($store)}
        <form method="POST" action="{base_url}/admin/store2-painel-coordenador">
            <input type="hidden" name="periodoCorrente" value="{$periodoCorrente}">
            <input type="hidden" name="digito" value="{$digito}">
            {foreach $perSelecionados as $p}
                <input type="hidden" name="perSelectedArray[]" value="{$p}">
            {/foreach}

            <h5 align="center" style="font-style: italic; margin-top: 2%; margin-bottom: 2%">Períodos Selecionados</h5>
            {foreach $perSelecionados as $ps}
                <div align="center">
                    <h4 align="center">• {$ps} </h4>

                    <a style="font-style: italic; font-weight: 500"><strong> Selecione os professores que deseja avaliar nesse período </strong></a>

                        <div align="center" class="col-4" style="text-align: left; margin-top: 1%">
                            <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: 2%">
                                <input type="checkbox" class="custom-control-input" onclick="hideProf({$ps})" name="todosProf_{$ps}" id="todosProf_{$ps}" >
                                <label class="custom-control-label" for="todosProf_{$ps}"><strong>Todos os professores</strong></label>
                            </div>

                            <div id="listProfessores_{$ps}" style="display: block">
                                {foreach $professores as $prof}
                                    <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: 2%">
                                        <input type="checkbox" class="custom-control-input" name="{$prof->getId()}and{$ps}" id="{$prof->getId()}and{$ps}" >
                                        <label class="custom-control-label" for="{$prof->getId()}and{$ps}">{$prof->getNome()}</label>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                </div>
                <hr>
            {/foreach}
                <div class=" text-center">
                    <div>
                        <a href="{path_for name="painelCoord"}" style="margin-top: 1%; width: 170px; height: 37px; " class="btn btn-outline-dark" type="submit"><span style="font-size: 15px">Editar os períodos</span></a>
                    </div>
                    <div>
                        <button style="margin-top: 1%; width: 250px; height: 40px;" class="btn btn-primary col-6 mx-auto" type="submit">Salvar</button>
                    </div>
                </div>
        </form>
        {elseif isset($store2)}
        <p align="center" style="font-size: 20px; font-style: italic; font-weigth: 500">Suas alterações foram salvas! Para editá-las novamente, clique no botão abaixo.</p>
            <div class="text-center">
                <div align="center">
                    <a href="{path_for name="painelCoord"}" style="margin-top: 2%; width: 170px; height: 37px; " class="btn btn-outline-dark" type="submit"><span style="font-size: 15px">Editar novamente</span></a>
                </div>
                <div align="center">
                    <a href="{path_for name="home"}" style="margin-top: 1%; width: 250px; height: 37px; " class="btn btn-success" type="submit"><span style="font-size: 15px">Concluído</span></a>
                </div>
            </div>
        {/if}
        
    </div>

{/block}
{block name="javascript"}
    <script>
        function hideProf(param){
            var list = document.getElementById('listProfessores_' + param);
            var check = document.getElementById('todosProf_' + param);

            if( check.checked == true ){
                list.style.display = "none";
            } else {
                list.style.display = "block";
            }
        }


    </script>
{/block}
