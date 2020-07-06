{extends 'layout.tpl'}
{block name=content}
    <h3 align="center" style="margin-top: 1%; margin-bottom: 1%" > Coordenadores </h3>
    <hr>
    
    <div align="center">
        <p style="font-style: italic; font-size: 20px"> 
            Selecione abaixo, quais docentes são coordenadores.
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

        <h5 align="center" style=" margin-bottom: 3%"> Atuais coordenadores: </h5>
        <div style="margin-left: 35%">
            {foreach $coordenadores as $coordenador}
                <div class="form-row" style="margin-top: 1%">
                    
                    <div style="margin-left: 0px; margin-bottom: 10px" class="col-lg-1 col-sm-1 col-md-1">
                        <button type="submit" name="exclui_{$coordenador->getId()}" ><a style=" color: darkred; margin-left: 0%;"><small><i class="fa fa-trash"></i></small></a></button>                         
                    </div>
                    <p style="margin-left: -2%"> •  {$coordenador->getNome()}</p>
                </div>
            {/foreach}
        </div>
        <hr>
        <div class="ml-4">
        <h4 style="font-size: 30px; margin-left: 9%" > Docentes </h4>
            <p  style=" font-size: 20px; font-style: italic; margin-left: 9%; margin-bottom: 3%">(Selecione até 4 professores para serem coordenadores)</p> 
            {foreach $professores as $professor}

                <div class="custom-control custom-checkbox" style="margin-left: 10%; margin-bottom: 1%; font-size: 17px" >
                    <input type="checkbox" class="custom-control-input" name="coord_{$professor->getId()}" id="{$professor->getId()}">
                    <label  class="custom-control-label" for="{$professor->getId()}">• {$professor->getNome()}</label>
                </div>

            {/foreach}
        </div>
        <div align="center" >
            <button  style="margin-top: 4%; width: 300px; height: 45px" class="btn btn-primary btn-lg" type="submit">Confirmar</button>  
        </div>
    </form>

{/block}

