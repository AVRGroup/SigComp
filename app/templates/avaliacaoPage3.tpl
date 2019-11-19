{extends 'layout.tpl'}
{block name=content}
<h2 class="text-center"> Avaliação </h2>
    <hr>
        <div style="border: 0.5px solid; width: 100%; margin-left: 0%; margin-bottom: 2%; margin-top: 2%">
            {if (isset($codigo) || isset($disciplina))}
              <p align="center" class="font-italic" style="font-size: 24px;">{$codigo} - {$disciplina}</p>  
            {/if}
        </div>
        <p style="margin-left: 10%; font-weight: 700; font-size: 29px"> Avaliação da turma</p>
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
        <form method="POST" action="{base_url}/store-avaliacao-3">    <!-- Começa o formulario -->
      
          {foreach $questoes as $questao}

            <p style=" font-size: 20px"> {$questao->getNumero()}- {$questao->getEnunciado()}</p> 
            
            {if $questao->getTipo() == 0 }
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio1{$questao->getNumero()}" name="customRadio03{$questao->getNumero()}" class="custom-control-input">
                <label class="custom-control-label" for="radio1{$questao->getNumero()}">1</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio2{$questao->getNumero()}" name="customRadio03{$questao->getNumero()}" class="custom-control-input">
                <label class="custom-control-label" for="radio2{$questao->getNumero()}">2</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio3{$questao->getNumero()}" name="customRadio03{$questao->getNumero()}" class="custom-control-input">
                <label class="custom-control-label" for="radio3{$questao->getNumero()}">3</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio4{$questao->getNumero()}" name="customRadio03{$questao->getNumero()}" class="custom-control-input">
                <label class="custom-control-label" for="radio4{$questao->getNumero()}">4</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio5{$questao->getNumero()}" name="customRadio03{$questao->getNumero()}" class="custom-control-input">
                <label class="custom-control-label" for="radio5{$questao->getNumero()}">5</label>
              </div>

            {/if}

            {if $questao->getTipo() == 1 }
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio1{$questao->getNumero()}" name="customRadio03{$questao->getNumero()}" class="custom-control-input">
                <label class="custom-control-label" for="radio1{$questao->getNumero()}">Sim</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio2{$questao->getNumero()}" name="customRadio03{$questao->getNumero()}" class="custom-control-input">
                <label class="custom-control-label" for="radio2{$questao->getNumero()}">Não</label>
              </div>

            {else}

            {/if}
          {/foreach}
        </form>
      </div>
    </div>    
</div>  
    <div class="text-sm-center" >
        <button class="btn btn-primary btn-lg btn-block" href="{path_for name="Enviar"}?disciplina={$disciplina}&codigo={$codigo}" style="margin-bottom: 1%" type="submit">Enviar </button>
    </div>
    <hr>
      <nav aria-label="navigation">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <a class="page-link" href="{path_for name="store-avaliacao-2"}?disciplina={$disciplina}&codigo={$codigo}" aria-label="Anterior">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Anterior</span>
            </a>
          </li>
          <li class="page-item"><a class="page-link" href="{path_for name="store-avaliacao-1"}?disciplina={$disciplina}&codigo={$codigo}">1</a></li>
          <li class="page-item"><a class="page-link" href="{path_for name="store-avaliacao-2"}?disciplina={$disciplina}&codigo={$codigo}">2</a></li>
          <li class="page-item"><a class="page-link" href="{path_for name="store-avaliacao-3"}?disciplina={$disciplina}&codigo={$codigo}">3</a></li>
          
        </ul>
      </nav>

{/block}