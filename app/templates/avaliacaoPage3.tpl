{extends 'layout.tpl'}
{block name=content}
<h2 class="text-center"> Avaliação </h2>
    <hr>
        <div style="border: 0.5px solid; width: 100%; margin-left: 0%; margin-bottom: 2%; margin-top: 2%">
            {if (isset($parametro))}
              <p align="center" class="font-italic" style="font-size: 24px;">{$parametro}</p>  
            {/if}
        </div>
        <p style="margin-left: 10%; font-weight: 700; font-size: 29px"> Avaliação da turma</p>
        <p style="margin-left: 10%; font-weight: 700; margin-bottom: 4%; font-size: 17px">*Faça sua avaliação, sendo 1 [Discordo Totalmente] e 5 [Concordo Totalmente].</p>


  <div style="margin-left:10%; margin-bottom: 10% ">           <!-- DIV PRINCIPAL -->
    <div style="margin-bottom: 3%">
      {foreach $questoes as $questao}
        <p style=" font-size: 20px"> {$questao->getNumero()}- {$questao->getEnunciado()}</p> 
        {if $questao->getTipo()==0}
          <div style=" font-size: 20px">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio1" name="customRadio01" class="custom-control-input">
                <label class="custom-control-label" for="radio1">1</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio2" name="customRadio01" class="custom-control-input">
                <label class="custom-control-label" for="radio2">2</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio3" name="customRadio01" class="custom-control-input">
                <label class="custom-control-label" for="radio3">3</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio4" name="customRadio01" class="custom-control-input">
                <label class="custom-control-label" for="radio4">4</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio5" name="customRadio01" class="custom-control-input">
                <label class="custom-control-label" for="radio5">5</label>
              </div>
          </div>
        {/if}

        {if $questao->getTipo()==1}
          <div style=" font-size: 20px">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio1" name="customRadio01" class="custom-control-input">
              <label class="custom-control-label" for="radio1">Sim</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio2" name="customRadio01" class="custom-control-input">
              <label class="custom-control-label" for="radio2">Não</label>
            </div>
          </div>

        {else}

        {/if}
      {/foreach}
    </div>    
</div>  
    <div class="text-sm-center" >
        <button class="btn btn-primary btn-lg btn-block" href="#" style="margin-bottom: 1%" type="submit">Enviar </button>
    </div>
    <hr>
      <nav aria-label="navigation">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <a class="page-link" href="{path_for name="avaliacaoPage02"}?disciplina={$parametro}" aria-label="Anterior">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Anterior</span>
            </a>
          </li>
          <li class="page-item"><a class="page-link" href="{path_for name="avaliacaoPage01"}?disciplina={$parametro}">1</a></li>
          <li class="page-item"><a class="page-link" href="{path_for name="avaliacaoPage02"}?disciplina={$parametro}">2</a></li>
          <li class="page-item"><a class="page-link" href="{path_for name="avaliacaoPage03"}?disciplina={$parametro}">3</a></li>
          
        </ul>
      </nav>

{/block}