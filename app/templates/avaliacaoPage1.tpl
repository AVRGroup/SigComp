{extends 'layout.tpl'}
{block name=content}
<h2 class="text-center"> Avaliação </h2>
    <hr>
        <div style="border: 0.5px solid; width: 100%; margin-left: 0%; margin-bottom: 2%; margin-top: 2%">
            {if (isset($codigo) || isset($disciplina))}
              <p align="center" class="font-italic" style="font-size: 24px;">{$codigo} - {$disciplina}</p>  
            {/if}
        </div>
        <p style="margin-left: 10%; font-weight: 700; font-size: 29px"> Avaliação pessoal</p>
        <p style="margin-left: 10%; font-weight: 700; margin-bottom: 4%; font-size: 17px">*Faça sua avaliação, sendo 1 [Discordo Totalmente] e 5 [Concordo Totalmente].</p>
        
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

  <div style="margin-left:10%; margin-bottom: 10% ">           <!-- DIV PRINCIPAL -->
    <div style="margin-bottom: 3%">
      
      <div style=" font-size: 20px">
        <form method="POST" action="{base_url}/store-avaliacao-1">    <!-- Começa o formulario -->
      
          {foreach $questoes as $questao}

            <p style=" font-size: 20px"> {$questao->getNumero()}- {$questao->getEnunciado()}</p> 
            
            {if $questao->getTipo() == 0 }
              <div class="custom-control custom-radio custom-control-inline">
                <input type=radio name="customRadio1_{$questao->getNumero()}" value="1"> 1
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type=radio name="customRadio1_{$questao->getNumero()}" value="2"> 2
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type=radio name="customRadio1_{$questao->getNumero()}" value="3"> 3
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type=radio name="customRadio1_{$questao->getNumero()}" value="4"> 4
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type=radio name="customRadio1_{$questao->getNumero()}" value="5"> 5
              </div>

            {/if}

            {if $questao->getTipo() == 1 }
              <div class="custom-control custom-radio custom-control-inline">
                <input type=radio name="customRadio1_{$questao->getNumero()}" value="sim"> Sim
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type=radio name="customRadio1_{$questao->getNumero()}" value="nao"> Não
              </div>

            {else}

            {/if}
          {/foreach}
        
        </div>
      </div>    
  </div>    

      <hr>
        <nav aria-label="navigation" class="pagination justify-content-center">
              <input class="page-item" type="submit" value="Próximo" />
          </form>
        </nav>
    
{/block}
