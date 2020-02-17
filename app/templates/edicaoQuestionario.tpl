{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Edição do Questionário </h2>
    <!-- 01#!/79awQxVp -->
    <hr>
    <p align="center" class="font-italic" style="font-size: 24px;"> Selecione a versão do questionário </p>

    <div class="row container ">
        <div align="center" class="col-lg-12 col-sm-12 col-md-12" >
            <div class="row">

                <select id="filtrar-data" class="form-control col-md-10 col-sm-12 mx-sm-auto">
                    <option disabled selected>Filtrar</option>
                    
                    {foreach $questionarios as $questionario}
                        {if $questionario != null}
                            <option value="versao_{$questionario->getVersao()}">{$questionario->getVersao()}</option>
                        {/if}
                    {/foreach}
                    
                </select>

            </div>
        </div>
    </div>

    <br>
    <p align="center" class="font-italic" style="font-size: 24px;"> Selecione a categoria das questões </p>

    <div class="row container ">
        <div align="center" class="col-lg-12 col-sm-12 col-md-12" >
            <div class="row">

                <select id="filtrar-data" class="form-control col-md-10 col-sm-12 mx-sm-auto">
                    <option disabled selected>Filtrar</option>
                    <option value="av_todas">Todas</option>
                    <option value="av_pessoal">Avaliação Pessoal</option>
                    <option value="av_prof">Avaliação do Professor</option>
                    <option value="av_turma">Avaliação da Turma</option>
                </select>

            </div>
        </div>
    </div>

{/block}