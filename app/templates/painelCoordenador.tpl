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
        <div align="center" style="margin-bottom: 3%;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {$completo}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
        </div>
    {/if}

    <div>
        <form method="POST" action="{base_url}/admin/store-painel-coordenador">

        <input type="hidden" name="periodoCorrente" value="{$periodoCorrente}">
        <input type="hidden" name="digito" value="{$digito}">
        <input type="hidden" name="periodos" value="{$periodos}">

            <h4 align="center" style="color: blue"> Período corrente: {$periodoCorrente} - {$digito}</h4>

        {if isset($index)}
            <h5 align="center" style="font-style: italic; margin-top: 2%; margin-bottom: 2%">Selecione abaixo os períodos que deseja ser utilizados na avaliação</h5>

            {foreach $periodos as $per}
                <div align="center">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="periodo_{$per}" name="customRadio_{$per}" class="custom-control-input" value="{$per}">
                        <label class="custom-control-label" for="periodo_{$per}">Período: {$per}</label>
                    </div>  
                </div>
            {/foreach}

            <div align="center">
                <button class="btn btn-outline-primary" style="width: 200px; margin-top: 3%" type="submit"> Salvar </button>
            </div>
        {elseif isset($store)}
            <h1 align="center"> OK </h1>
        {/if}
        </form>
        
    </div>

{/block}