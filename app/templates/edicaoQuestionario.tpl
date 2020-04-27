{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Edição do Questionário </h2>
    <!-- 01#!/79awQxVp -->
    <hr>

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

    <p align="center" class="font-italic" style="font-size: 24px;"> Selecione a versão do questionário </p>

    <form method="POST" action="{base_url}/edicao-questoes">    <!-- Começa o formulario -->
        <input type="hidden" name="base_url" value="{base_url}">
        <input type="hidden" name="filtro_categoria" value="3">

        <div class="row container ">
            <div align="center" class="col-lg-12 col-sm-12 col-md-12" >
                <div class="row">

                    <select id="filtrar-data" name="filtro_versao" class="form-control col-md-10 col-sm-12 mx-sm-auto">
                        <option disabled selected>Filtrar</option>
                        
                        {foreach $questionarios as $questionario}
                            {if $questionario != null}
                                <option value="{$questionario->getVersao()}" >
                                    {if !empty($questionario->getNome())}{$questionario->getNome()}
                                    {else}{$questionario->getVersao()}{/if}
                                </option>
                            {/if}
                        {/foreach}
                        
                    </select>


                </div>
            </div>
        </div>

    <nav aria-label="navigation" class="pagination justify-content-center">
        <button style="margin-top: 2%" class="btn btn-primary" type="submit">Editar</button>
    </form>
    </nav>

{/block}
