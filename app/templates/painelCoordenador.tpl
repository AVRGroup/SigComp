{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Painel Coordenador </h2>

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
        <h5 align="center" style="font-style: italic; margin-top: 2%">Selecione abaixo os períodos que deseja ser utilizados na avaliação</h5>

        <div align="center">
            <a class="btn btn-outline-primary" style="width: 200px; margin-top: 3%" href="{path_for name="storePainelCoord"}"> Salvar </a>
        </div>
    </div>

{/block}