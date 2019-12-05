  
{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Questões </h2>
    <hr>

    <div class="row container ">
        <div align="center" class="col-lg-12 col-sm-12 col-md-12" >
            <div class="row">
                <form method="POST" action="{base_url}/store-questao">    <!-- Formulario para adicionar questao -->
                    <input type="text" id="nova-questao" name="nova-questao" class="custom-control-input" value="Digite a questão">
                    <div class="button">
                        <button type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row container ">
        <div align="center" class="col-lg-12 col-sm-12 col-md-12" >
            <div class="row">
                {foreach $questoes as $questao}
                    <p style=" font-size: 20px"> {$questao->getNumero()}- {$questao->getEnunciado()}</p>
                {/foreach}
            </div>
        </div>
    </div>

{/block}