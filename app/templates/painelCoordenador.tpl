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

    <div>
        {if isset($index)}
        <p align="center" style="font-weight: 400; font-size: 20px">Essa página envia e-mails para os alunos que cursaram disciplinas no período e com o professor selecionado.</p>
        <form method="POST" action="{base_url}/admin/store-painel-coordenador">

            <input type="hidden" name="periodoCorrente" value="{$periodoCorrente}">
            <input type="hidden" name="digito" value="{$digito}">
            {foreach $periodos as $p}
                <input type="hidden" name="periodosArray[]" value="{$p}">
            {/foreach}

                <h4 align="center" style="color: blue"> Período corrente: {$periodoCorrente} - {$digito}</h4>

                <h5 align="center" style="font-style: italic; margin-top: 2%; margin-bottom: 2%">Selecione abaixo os períodos que deseja reforçar a avaliação!</h5>

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
        <div align="center">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <b>Atenção!</b> O processo de envio dos e-mails pode demorar um pouco!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <form method="POST" action="{base_url}/admin/store2-painel-coordenador">
            <input type="hidden" name="periodoCorrente" value="{$periodoCorrente}">
            <input type="hidden" name="digito" value="{$digito}">
            {foreach $perSelecionados as $p}
                <input type="hidden" name="perSelectedArray[]" value="{$p}">
            {/foreach}

            <h5 align="center" style="font-style: italic; margin-top: 2%; margin-bottom: 2%">Período(s) Selecionado(s)</h5>
            {foreach $perSelecionados as $ps}
                <div align="center" style="margin-top: 2%">
                    <h4 align="center">• {$ps} </h4>
                    <a style="font-style: italic; font-weight: 500"><strong> Selecione o professor que deseja reforçar a avaliação nesse período! </strong></a>

                    <div align="center" class="col-8" style="text-align: left; margin-top: 1%">
                        <div class="form-row ">
                            <select class="form-control col-8 mx-auto" name="professores_{$ps}">
                                <option value="todos" selected>Todos</option>
                                {foreach $professores as $p}
                                    <option value="{$p->getId()}/{$ps}">{$p->getNome()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
            {/foreach}
                <div class=" text-center" style="margin-top: 2%">
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
                    <a href="{path_for name="home"}" style="margin-top: 1%; width: 250px; height: 37px;" id="btnConcluido" class="btn btn-success" type="submit"><span style="font-size: 15px">Concluído</span></a>
                </div>
            </div>
        {/if}
    </div>

{/block}
{block name="javascript"}
    <script>
        var btnConcluido = document.getElementById('btnConcluido');

        btnConcluido.addEventListener('click', function(event){
            var result = confirm('Confirmar o envio dos e-mails?');
            
            result ? submit : event.preventDefault();
        })
    </script>
{/block}