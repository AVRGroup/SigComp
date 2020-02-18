{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Edição do Questionário </h2>
    <!-- 01#!/79awQxVp -->
    <hr>

    <form method="POST" action="{base_url}/edicao-questoes">    <!-- Começa o formulario -->
        <div class="row container">
            <div class="col-lg-12 col-sm-12 col-md-12" >
                    {foreach $questoes as $questao}
                        <div class="row justify-content-left">
                            <p style=" font-size: 20px"> {$questao->getNumero()}- {$questao->getEnunciado()}</p>
                        </div>
                    {/foreach}

            </div>
        </div>
    <nav aria-label="navigation" class="pagination justify-content-center">
        <button style="margin-top: 2%" class="btn btn-primary" type="submit">Editar</button>
    </form>
    </nav>

{/block}