{extends 'layout.tpl'}
{block name=content}
<h2 class="text-center"> Avaliação </h2>

  

    <hr>
        <div style="border: 0.5px solid; width: 100%; margin-left: 0%; margin-bottom: 2%; margin-top: 2%">
            {if (isset($codigo) || isset($disciplina))}
              <p align="center" class="font-italic" style="font-size: 24px;">{$codigo} - {$disciplina}</p>  
            {/if}
        </div>
        <p style="margin-left: 10%; font-weight: 700; font-size: 29px"> Avaliação do professor</p>
        <!--{if $professor !== null}
          <p style="margin-left: 10%; font-weight: 700; font-size: 23px"> {$professor->getNome()}</p>
        {/if}!-->
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
        <form method="POST" action="{base_url}/store-avaliacao-2">    <!-- Começa o formulario -->

        {foreach $respostas1 as $r}
          <input type="hidden" name="respostas1[]" value="{$r}">
        {/foreach}

          <input type="hidden" name="codigo" value="{$codigo}">
          <input type="hidden" name="disciplina" value="{$disciplina}">
          <input type="hidden" name="id_disciplina" value="{$id_disciplina}">

          {foreach $questoes2 as $questao}

            {$numero = $questaoQuestionarioDAO->getNumeroQuestao($versaoAtual, $questao->getId())}

            <p style=" font-size: 20px; margin-top: 4%"> {$numero}- {$questao->getEnunciado()}</p> 
            
            {if $questao->getTipo() == 0 }
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio1{$numero}" name="customRadio2_{$numero}" class="custom-control-input" value="1">
                <label class="custom-control-label" for="radio1{$numero}">1</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio2{$numero}" name="customRadio2_{$numero}" class="custom-control-input" value="2">
                <label class="custom-control-label" for="radio2{$numero}">2</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio3{$numero}" name="customRadio2_{$numero}" class="custom-control-input" value="3">
                <label class="custom-control-label" for="radio3{$numero}">3</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio4{$numero}" name="customRadio2_{$numero}" class="custom-control-input" value="4">
                <label class="custom-control-label" for="radio4{$numero}">4</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio5{$numero}" name="customRadio2_{$numero}" class="custom-control-input"  value="5">
                <label class="custom-control-label" for="radio5{$numero}">5</label>
              </div>

            {/if}

            {if $questao->getTipo() == 1 }
               <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio1{$numero}" name="customRadio2_{$numero}" class="custom-control-input" value="1">
                <label class="custom-control-label" for="radio1{$numero}">Sim</label>
              </div>
               <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio2{$numero}" name="customRadio2_{$numero}" class="custom-control-input" value="0">
                <label class="custom-control-label" for="radio2{$numero}">Não</label>
              </div>

            {else}

            {/if}
          {/foreach}
        
      </div>
    </div>    
</div> 
  <hr>
      <nav aria-label="navigation" class="pagination justify-content-center">
        <button style="margin-top: 2%" class="btn btn-primary" type="submit">Próximo</button>
        </form>
      </nav>

{/block}