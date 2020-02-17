{extends 'layout.tpl'}
{block name=content}
    <h3 align="center" style="margin-top: 2%; margin-bottom: 3%" > Coordenadores </h3>
    <hr>
    <h5 align="center" style="margin-bottom: 2%"> Selecione abaixo, quais professores são coordenadores. </h5>

        <h5 style="margin-left: 7%; margin-bottom: 2%" > Atuais coordenadores </h5>
        
    {if ( isset($coordSI) ) }
        <p style="margin-left: 7%"> •  {$coordSI}</p>
    {/if}
    {if ( isset($coordCC) ) }
        <p style="margin-left: 7%"> •  {$coordCC}</p>
    {/if}   
    {if ( isset($coordEC) ) }
        <p style="margin-left: 7%"> •  {$coordEC}</p>
    {/if}
        <hr>


    <div align="center" style="margin-bottom: 4%">
          {if isset($incompleto)}
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {$incompleto}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
          {/if}
    </div>

    <form method="POST" action="{base_url}/admin/storeEditCoord">
        <div class="ml-4">
        {foreach $professores as $professor}

            <div class="custom-control custom-checkbox" style="margin-bottom: 1%; font-size: 17px" >
                <input type="checkbox" class="custom-control-input" name="{$professor->getId()}" id="{$professor->getId()}">
                <label class="custom-control-label" for="{$professor->getId()}">• {$professor->getNome()}</label>
            </div>
                <div style="margin-bottom: 2%">
                    <select name="curso_{$professor->getId()}" class="form-control col-md-6 col-sm-6 ">
                    <option disabled selected>Selecione o curso</option>
                    <option value="Sistema de informação">Sistema de informação</option>
                    <option value="Ciência da computação">Ciência da computação</option>
                    <option value="Engenharia computacional">Engenharia computacional</option>
                    </select>
                </div>

        {/foreach}
    </div>

    <div align="center" >
        <button  style="margin-top: 2%" class="btn btn-primary btn-lg" type="submit">Confirmar</button>  
    </form>
    </div>

{/block}

