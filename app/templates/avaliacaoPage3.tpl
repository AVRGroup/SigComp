{extends 'layout.tpl'}
{block name=content}
<h2 class="text-center"> Avaliação </h2>
    <hr>
        <div style="border: 0.5px solid; width: 100%; margin-left: 0%; margin-bottom: 2%; margin-top: 2%">
            <p align="center" class="font-italic" style="font-size: 24px;"> DCC013 - Estrutura de dados </p>
        </div>
        <p style="margin-left: 10%; font-weight: 700; font-size: 29px"> Avaliação da disciplina</p>
        <p style="margin-left: 10%; font-weight: 700; margin-bottom: 4%; font-size: 17px">*Faça sua avaliação, sendo 1 [Não] e 5 [Sim].</p>

    <div style="margin-left:10%; margin-bottom: 5% ">           <!-- DIV PRINCIPAL -->

        <div style="margin-bottom: 3%">
            <p style=" font-size: 20px"> 1 - O material utilizado em aula é atualizado?</p>
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
        </div>

    <div style="margin-bottom: 3%">
        <p style=" font-size: 20px"> 2 - O conteúdo programático da disciplina foi cumprido?</p>
        <div style=" font-size: 20px">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio6" name="customRadio02" class="custom-control-input">
              <label class="custom-control-label" for="radio6">1</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio7" name="customRadio02" class="custom-control-input">
              <label class="custom-control-label" for="radio7">2</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio8" name="customRadio02" class="custom-control-input">
              <label class="custom-control-label" for="radio8">3</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio9" name="customRadio02" class="custom-control-input">
              <label class="custom-control-label" for="radio9">4</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio10" name="customRadio02" class="custom-control-input">
              <label class="custom-control-label" for="radio10">5</label>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 3%">
        <p style=" font-size: 20px"> 3 - As avaliações refletem o conteúdo apresentado em sala?</p>
        <div style=" font-size: 20px">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio11" name="customRadio03" class="custom-control-input">
              <label class="custom-control-label" for="radio11">1</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio12" name="customRadio03" class="custom-control-input">
              <label class="custom-control-label" for="radio12">2</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio13" name="customRadio03" class="custom-control-input">
              <label class="custom-control-label" for="radio13">3</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio14" name="customRadio03" class="custom-control-input">
              <label class="custom-control-label" for="radio14">4</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio15" name="customRadio03" class="custom-control-input">
              <label class="custom-control-label" for="radio15">5</label>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 3%">
        <p style=" font-size: 20px"> 4 - As notas das avaliações foram publicadas até três dias antes da avaliação seguinte?</p>
        <div style=" font-size: 20px">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio16" name="customRadio04" class="custom-control-input">
              <label class="custom-control-label" for="radio16">1</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio17" name="customRadio04" class="custom-control-input">
              <label class="custom-control-label" for="radio17">2</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio18" name="customRadio04" class="custom-control-input">
              <label class="custom-control-label" for="radio18">3</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio19" name="customRadio04" class="custom-control-input">
              <label class="custom-control-label" for="radio19">4</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio20" name="customRadio04" class="custom-control-input">
              <label class="custom-control-label" for="radio20">5</label>
            </div>
        </div>
    </div>

     <div style="margin-bottom: 3%">
        <p style=" font-size: 20px"> 5 - A bibliografia é adequada ao conteúdo da disciplina?</p>
        <div style=" font-size: 20px">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio21" name="customRadio05" class="custom-control-input">
              <label class="custom-control-label" for="radio21">1</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio22" name="customRadio05" class="custom-control-input">
              <label class="custom-control-label" for="radio22">2</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio23" name="customRadio05" class="custom-control-input">
              <label class="custom-control-label" for="radio23">3</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio24" name="customRadio05" class="custom-control-input">
              <label class="custom-control-label" for="radio24">4</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio25" name="customRadio05" class="custom-control-input">
              <label class="custom-control-label" for="radio25">5</label>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 3%">
        <p style=" font-size: 20px"> 6 - Os objetivos da disciplina foram atendidos?</p>
        <div style=" font-size: 20px">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio26" name="customRadio06" class="custom-control-input">
              <label class="custom-control-label" for="radio26">1</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio27" name="customRadio06" class="custom-control-input">
              <label class="custom-control-label" for="radio27">2</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio28" name="customRadio06" class="custom-control-input">
              <label class="custom-control-label" for="radio28">3</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio29" name="customRadio06" class="custom-control-input">
              <label class="custom-control-label" for="radio29">4</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio35" name="customRadio06" class="custom-control-input">
              <label class="custom-control-label" for="radio30">5</label>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 3%">
        <p style=" font-size: 20px"> 7 - A ementa da disciplina é adequada?</p>
        <div style=" font-size: 20px">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio31" name="customRadio07" class="custom-control-input">
              <label class="custom-control-label" for="radio31">1</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio32" name="customRadio07" class="custom-control-input">
              <label class="custom-control-label" for="radio32">2</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio33" name="customRadio07" class="custom-control-input">
              <label class="custom-control-label" for="radio33">3</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio34" name="customRadio07" class="custom-control-input">
              <label class="custom-control-label" for="radio34">4</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio35" name="customRadio07" class="custom-control-input">
              <label class="custom-control-label" for="radio35">5</label>
            </div>
        </div>
    </div> 
</div>
    <div class="text-sm-center" >
            <button class="btn btn-primary btn-lg btn-block" style="margin-bottom: 1%" type="submit">Enviar </button>
    </div>
    <hr>
      <nav aria-label="navigation">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Anterior">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Anterior</span>
            </a>
          </li>
          <li class="page-item"><a class="page-link" href="{path_for name="avaliacaoPage01"}">1</a></li>
          <li class="page-item"><a class="page-link" href="{path_for name="avaliacaoPage02"}">2</a></li>
          <li class="page-item"><a class="page-link" href="{path_for name="avaliacaoPage03"}">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Próximo">
              <span aria-hidden="true">&raquo;</span>
              <span class="sr-only">Próximo</span>
            </a>
          </li>
        </ul>
      </nav>

{/block}