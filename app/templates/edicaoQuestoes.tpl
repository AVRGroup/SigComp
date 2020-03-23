{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Edição do Questionário </h2>
    <!-- 01#!/79awQxVp -->
    <hr>

    <form method="POST" action="{base_url}/store-questoes">    <!-- Começa o formulario -->

        <input type="hidden" name="versao" value="{$versao}">
        <input type="hidden" name="categoria" value="{$categoria}">
        <input type="hidden" name="filtro_categoria" value="{$categoria}">
        <input type="hidden" name="filtro_versao" value="{$versao}">

        {if $categoria == "0" || $categoria == "3"}
            <br>
            <p align="center" style=" font-weight: 750; font-size: 25px"> Avaliação pessoal</p>
            {foreach $questoes as $questao}  
                {if $questao->getCategoria() == 0}
                    <div class="form-row" style="margin-top: 3%">
                        <div class="col-lg-1 col-sm-1 col-md-1 d-flex justify-content-end">
                            {$questao->getNumero()}-
                        </div>
                        <div class="col-lg-10 col-sm-10 col-md-10">
                            <input type="text" name="edita_{$questao->getId()}" class="form-control" value="{$questao->getEnunciado()}">
                        </div>
                        <div class="col-lg-1 col-sm-1 col-md-1">
                            <button style="margin-top: 2%" type="submit" name="exclui_{$questao->getId()}" ><a style="color: darkred; margin-left: 2%"><small><i class="fa fa-trash"></i></small></a></button>                         
                        </div>
                    </div>
                {/if}
            {/foreach}
            <div class="form-row justify-content-center" style="margin-top: 3%">
                <div align="center" class="col-lg-12 col-sm-12 col-md-12" id="av_pessoal">
                    <!-- O input vai entrar aqui-->
                </div>
            </div>
        {/if}

        <!-- Botão de adicionar-->
        <div class="form-row justify-content-center" style="margin-top: 3%; margin-bottom: 3%">
                <button class="btn btn-primary " type="button" name="av_pessoal" id="adicionar3">Adicionar</button>
        </div>
        <hr>

        {if $categoria == "1" || $categoria == "3"}
            <br>
            <p align="center" style=" font-weight: 750; font-size: 25px"> Avaliação da turma</p>
            {foreach $questoes as $questao}  
                {if $questao->getCategoria() == 1}
                    <div class="form-row" style="margin-top: 3%">
                        <div class="col-lg-1 col-sm-1 col-md-1 d-flex justify-content-end">
                            {$questao->getNumero()}-
                        </div>
                        <div class="col-lg-10 col-sm-10 col-md-10">
                            <input type="text" name="edita_{$questao->getId()}" class="form-control" value="{$questao->getEnunciado()}">
                        </div>
                        <div class="col-lg-1 col-sm-1 col-md-1">
                            <button style="margin-top: 2%" type="submit" name="exclui_{$questao->getId()}" ><a style="color: darkred; margin-left: 2%"><small><i class="fa fa-trash"></i></small></a></button>
                        </div>
                    </div>
                {/if}
            {/foreach}
            <div class="form-row justify-content-center" style="margin-top: 3%">
                <div align="center" class="col-lg-12 col-sm-12 col-md-12" id="av_turma">
                    <!-- O input vai entrar aqui-->
                </div>
            </div>
        {/if}

        <!-- Botão de adicionar-->
            <div class="form-row justify-content-center" style="margin-top: 3%; margin-bottom: 3%">
                <button class="btn btn-primary " type="button" name="av_turma" id="adicionar2">Adicionar</button>
            </div>
        <hr>
        {if $categoria == "2" || $categoria == "3"}
            <br>
            <p align="center" style=" font-weight: 750; font-size: 25px"> Avaliação do professor</p>
            {foreach $questoes as $questao}  
                {if $questao->getCategoria() == 2}
                    <div class="form-row" style="margin-top: 3%">
                        <div class="col-lg-1 col-sm-1 col-md-1 d-flex justify-content-end">
                            {$questao->getNumero()}-
                        </div>
                        <div class="col-lg-10 col-sm-10 col-md-10">
                            <input type="text" name="edita_{$questao->getId()}" class="form-control" value="{$questao->getEnunciado()}">
                        </div>
                        <div class="col-lg-1 col-sm-1 col-md-1">
                            <button style="margin-top: 2%" type="submit" name="exclui_{$questao->getId()}" ><a style="color: darkred; margin-left: 2%"><small><i class="fa fa-trash"></i></small></a></button>
                        </div>
                    </div>
                {/if}
            {/foreach}

            <!-- Abaixo está o botão de adicionar-->
            <div class="form-row justify-content-center" style="margin-top: 3%">
                <div align="center" class="col-lg-12 col-sm-12 col-md-12" id="av_prof">
                    <!-- O input vai entrar aqui-->
                </div>
            </div>

            <div class="form-row justify-content-center" style="margin-top: 3%; margin-bottom: 3%">
                <button class="btn btn-primary " type="button" name="av_prof" id="adicionar1">Adicionar</button>
            </div>

        {/if}

        <br>
        <p align="center" style="margin-top: 2%; font-weight: 700; font-size: 25px"> Nome do Questionário</p>
        <p align="center" style=" font-weight: 600; font-size: 15px"> (Clique pra editar)</p>
        <div class="form-row justify-content-center" style="margin-top: 2%">
            <div class="col-lg-10 col-sm-10 col-md-10">
                <input type="text" name="nomeQuestionario" class="form-control" value="{$questionario->getNome()}">
            </div>
        </div>

    <div align="center"  class="col-lg-12 col-md-12">
        <nav aria-label="navigation" class="pagination justify-content-center">
            <button style="margin-top: 3%; margin-bottom: 2%; " class="btn btn-outline-primary " type="submit" name="salvar" >  Salvar </button>
        </form>
        </nav>
    </div>

{/block}

{block name="javascript"}
    <script>
        const adicionar1 = document.getElementById("adicionar1");
        const adicionar2 = document.getElementById("adicionar2");
        const adicionar3 = document.getElementById("adicionar3");

        const av_prof = document.getElementById("av_prof");
        const av_pessoal = document.getElementById("av_pessoal");
        const av_turma = document.getElementById("av_turma");

        adicionar1.addEventListener("click", function (event) {
        var input = document.createElement("input"); 
        input.id = "adicionada";
        input.name = "add_enunciado";
        input.placeholder = " Digite o enunciado da questão";
        input.type = "text";
        input.class = "form-control";
        input.size = "126";
        input.style = "margin-top: 2%"; 

        av_prof.appendChild(input);

        });

        adicionar3.addEventListener("click", function (event) {
        var input = document.createElement("input"); 
        input.id = "adicionada";
        input.name = "add_enunciado";
        input.placeholder = " Digite o enunciado da questão";
        input.type = "text";
        input.class = "form-control";
        input.size = "126";
        input.style = "margin-top: 2%"; 

        av_pessoal.appendChild(input);

        });

        adicionar2.addEventListener("click", function (event) {
        var input = document.createElement("input"); 
        input.id = "adicionada";
        input.name = "add_enunciado";
        input.placeholder = " Digite o enunciado da questão";
        input.type = "text";
        input.class = "form-control";
        input.size = "126";
        input.style = "margin-top: 2%"; 

        av_turma.appendChild(input);

        });
    </script>
{/block}

 var divNova = document.createElement("div"); 
  var conteudoNovo = document.createTextNode("Olá, cumprimentos!"); 
  divNova.appendChild(conteudoNovo); //adiciona o nó de texto à nova div criada 

  // adiciona o novo elemento criado e seu conteúdo ao DOM 
  var divAtual = document.getElementById("div1"); 
  document.body.insertBefore(divNova, divAtual); 