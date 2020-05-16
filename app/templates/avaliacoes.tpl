{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Avaliação </h2>
    <!-- 01#!/79awQxVp -->
    <hr>
    <p align="center" class="font-italic" style="font-size: 24px;"> Selecione uma disciplina </p>

    <div align="center" style="margin-bottom: 1%;">
          {if isset($completo)}
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {$completo}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
            </div>
          {/if}
    </div>

    <div class="container ">
        <div align="center" class="col-lg-12 col-sm-12 col-md-12" >
            <div class="container">
                {$notas_usuario = $usuario->getNotas()}
                    {foreach $notas_usuario as $nota}
                    {$show = true}
                        {if $nota->getPeriodo() == $periodoPassado}
                            <div class="container">    
                                {foreach $disciplinas_avaliadas as $disci}
                                    {if $disci == $nota->getDisciplina()->getId()}
                                        <button type="button" class="btn btn-lg btn-primary col-lg-6 col-sm-12 col-md-12 text-truncate" style="margin-top: 1%" disabled> {$nota->getDisciplina()->getCodigo()} - {$nota->getDisciplina()->getNome()}</button>
                                        {$show = false}
                                        {break}
                                    {/if}
                                {/foreach}
                            {if $show}
                                <a href="{path_for name="avaliacaoPage01"}?disciplina={$nota->getDisciplina()->getId()}" class="text-truncate btn btn-primary btn-lg active col-lg-6 col-sm-12 col-md-12" style="margin-top: 1%" role="button" aria-pressed="true"> {$nota->getDisciplina()->getCodigo()} - {$nota->getDisciplina()->getNome()}</a>
                            {/if}
                            </div>
                        {/if}
                    {/foreach}
                <hr>
            </div>
        </div>
    </div>
    {if isset($concluiu)}
        <p align="center" style="font-weight: 500; font-size: 25px">Você concluiu as avaliações!</p>
        <p align="center" style="font-weight: 400; font-size: 20px">Continue assim para conquistar novas medalhas!</p>
        
        <div align="center">
            <div style="max-width: 120px; margin-top: 4%">
                <img src="{base_url}/img/b_avaliacao_4.png" class="img-thumbnail" alt="not found" width="120" height="120">       
                <div class="caption">
                    <p style="font-size: 20px; " class="text-center"><small class="legenda-imagem">TESTE NOME</small></p>
                </div>
            </div>
        </div>
        <form method="POST" action="{path_for name="home"}">  
        <nav aria-label="navigation" class="pagination justify-content-center">
            <button style="margin-top: 2%; width: 300px; height: 45px" class="btn btn-primary" type="submit">Confirmar</button>  
          </form>
        </nav>
    </form>
        
    {/if}
{/block}