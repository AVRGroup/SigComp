{extends 'layout.tpl'}
{block name=content}
    <h3 align="center" style="margin-top: 2%; margin-bottom: 3%" > Coordenadores </h3>
    <hr>
    
    <div align="center">
        <p style="font-weight: 500; font-size: 20px; border:solid thick black; border-radius: 0.5em; border-width:3px; padding-left:9px; padding-top:6px; padding-bottom:6px; margin:2px; margin-bottom:10px; width:500px;"> 
            Selecione abaixo, quais professores são coordenadores. 
        </p>
    </div>

    <div align="center" style="margin-bottom: 4%;">
        {if isset($completo)}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {$completo}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        {/if}
    </div>

    <div align="center" style="margin-bottom: 4%;">
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
        <input type="hidden" name="professores" value="{$professores}">
        <input type="hidden" name="coordenadores" value="{$coordenadores}">

        <h5 style="margin-left: 7%; margin-top: 5%; margin-bottom: 2%" > Atuais coordenadores: </h5>
        {foreach $coordenadores as $coordenador}
            <div class="form-row" style="margin-top: 1%">
                <p style="margin-left: 10%"> •  {$coordenador->getNome()}</p>

                 <div style="margin-left: 5px; margin-bottom: 10px" class="col-lg-1 col-sm-1 col-md-1">
                    <button type="submit" name="exclui_{$coordenador->getId()}" ><a style=" color: darkred; margin-left: 2%;"><small><i class="fa fa-trash"></i></small></a></button>                         
                </div>
            </div>
        {/foreach}
        
        <hr>

        <div class="ml-4">
        {foreach $professores as $professor}

            <div class="custom-control custom-checkbox" style="margin-left: 5%; margin-bottom: 1%; font-size: 17px" >
                <input type="checkbox" class="custom-control-input" name="coord_{$professor->getId()}" id="{$professor->getId()}">
                <label  class="custom-control-label" for="{$professor->getId()}">• {$professor->getNome()}</label>
            </div>

        {/foreach}
    </div>

    <div align="center" >
        <button  style="margin-top: 2%" class="btn btn-primary btn-lg" type="submit">Confirmar</button>  
    </form>
    </div>

{/block}

