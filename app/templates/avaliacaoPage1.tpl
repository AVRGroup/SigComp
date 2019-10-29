{extends 'layout.tpl'}
{block name=content}
<h2 class="text-center"> Avaliação </h2>
    <hr>
        <div style="border: 0.5px solid; width: 100%; margin-left: 0%; margin-bottom: 2%; margin-top: 2%">
            <p align="center" class="font-italic" style="font-size: 24px;"> DCC013 - Estrutura de dados </p>
        </div>
        <p style="margin-left: 10%; font-weight: 700; font-size: 29px"> Avaliação pessoal</p>
        <p style="margin-left: 10%; font-weight: 700; margin-bottom: 4%; font-size: 17px">*Faça sua avaliação, sendo 1 [Não] e 5 [Sim].</p>
    
  <div style="margin-left:10%; margin-bottom: 10% ">           <!-- DIV PRINCIPAL -->
    <div style="margin-bottom: 3%">
        <p style=" font-size: 20px"> 1 - Você é pontual ?</p>
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
        <p style=" font-size: 20px"> 2 - Você é assíduo às aulas?</p>
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
        <p style=" font-size: 20px"> 3 - Você procurou o professor, tutor ou monitor da disciplina para tirar dúvidas ao longo do semestre?</p>
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
        <p style=" font-size: 20px"> 4 - Você faz as atividades práticas propostas?</p>
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
        <p style=" font-size: 20px"> 5 - Sua nota reflete de modo fiel o conhecimento que você reteve ao longo do curso?</p>
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
        <p style=" font-size: 20px"> 6 - Você se dedicou à disciplina?</p>
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
              <input type="radio" id="radio30" name="customRadio06" class="custom-control-input">
              <label class="custom-control-label" for="radio30">5</label>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 3%">
        <p style=" font-size: 20px"> 7 - Quais dos itens abaixo você utilizou para estudar para a disciplina?</p>
        <div style=" font-size: 20px">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck1">
              <label class="custom-control-label" for="customCheck1">Livros da bibliografia</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck2">
              <label class="custom-control-label" for="customCheck2">Outros Livros</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck3">
              <label class="custom-control-label" for="customCheck3">Slides do professor</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck4">
              <label class="custom-control-label" for="customCheck4">Textos na web</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck5">
              <label class="custom-control-label" for="customCheck5">Lista de exercícios</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck6">
              <label class="custom-control-label" for="customCheck6">Vídeos </label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck7">
              <label class="custom-control-label" for="customCheck7">Outros</label>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 3%">
        <p style=" font-size: 20px"> 8 - Você possuía a base teórica necessária para cursar esta disciplina?</p>
        <div style=" font-size: 20px">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio38" name="customRadio08" class="custom-control-input">
              <label class="custom-control-label" for="radio38">1</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio39" name="customRadio08" class="custom-control-input">
              <label class="custom-control-label" for="radio39">2</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio40" name="customRadio08" class="custom-control-input">
              <label class="custom-control-label" for="radio40">3</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio41" name="customRadio08" class="custom-control-input">
              <label class="custom-control-label" for="radio41">4</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio42" name="customRadio08" class="custom-control-input">
              <label class="custom-control-label" for="radio42">5</label>
            </div>
        </div>
    </div>
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
