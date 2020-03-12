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
            <p style="margin-left: 40%; font-weight: 700; font-size: 20px"> Avaliação pessoal</p>
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
        {/if}

        <!-- Botão de adicionar-->

        {if $categoria == "1" || $categoria == "3"}
            <br>
            <p style="margin-left: 40%; font-weight: 700; font-size: 20px"> Avaliação da turma</p>
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
        {/if}

        <!-- Botão de adicionar-->

        {if $categoria == "2" || $categoria == "3"}
            <br>
            <p style="margin-left: 40%; font-weight: 700; font-size: 20px"> Avaliação do professor</p>
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

            <div class="form-row justify-content-center" style="margin-top: 3%">
                <button type="button" id="adicionar">Adicionar</button>
            </div>

        {/if}

        <br>
        <p style="margin-left: 40%; font-weight: 700; font-size: 20px"> Nome do Questionário</p>
        <div class="form-row justify-content-center" style="margin-top: 3%">
            <div class="col-lg-10 col-sm-10 col-md-10">
                <input type="text" name="nomeQuestionario" class="form-control" value="{$questionario->getNome()}">
            </div>
        </div>


    <nav aria-label="navigation" class="pagination justify-content-center">
        <button style="margin-top: 2%" class="btn btn-primary" type="submit" name="salvar" >Salvar</button>
    </form>
    </nav>

{/block}

{block name="javascript"}
    <script>
        const adicionar = document.getElementById("adicionar");
        const av_prof = document.getElementById("av_prof");

        adicionar.addEventListener("click", function (event) {
        var input = document.createElement("input");
        input.name = "cria";
        input.placeholder = "Digite o enunciado da questão";
        input.type = "text";
        input.class = "form-control";
        input.size = "126";
        av_prof.appendChild(input);
        });
    </script>
{/block}

var divNova = document.createElement("div"); 
  var conteudoNovo = document.createTextNode("Olá, cumprimentos!"); 
  divNova.appendChild(conteudoNovo); //adiciona o nó de texto à nova div criada 

  // adiciona o novo elemento criado e seu conteúdo ao DOM 
  var divAtual = document.getElementById("div1"); 
  document.body.insertBefore(divNova, divAtual); 