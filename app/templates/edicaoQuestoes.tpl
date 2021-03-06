{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Edição do Questionário </h2>
    <!-- 01#!/79awQxVp -->
    <hr>

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

    <div align="center" style="margin-bottom: 4%;">
        {if isset($completo)}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {$completo}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        {/if}
    </div>

    <form name="formulario" method="POST" action="{base_url}/store-questoes">    <!-- Começa o formulario -->

        <input type="hidden" name="versao" value="{$versao}">
        <input type="hidden" name="categoria" value="{$categoria}">
        <input type="hidden" name="filtro_categoria" value="{$categoria}">
        <input type="hidden" name="filtro_versao" value="{$versao}">
        <input type="hidden" name="nome_questionario" value="{$nome_questionario}">

        <div align="center">
            <p align="center" style="font-weight: 500; font-size: 20px; border:solid thick blue; border-radius: 0.5em; 
              border-width:3px; padding-left:9px; padding-top:6px; 
              padding-bottom:6px; margin:2px; margin-bottom:5px; width:500px;">Você está editando o questionário: {$nome_questionario }</p>
        </div>

        {if $categoria == "0" || $categoria == "3"}
            <br>
            <p align="center" style=" font-weight: 750; font-size: 25px"> Avaliação pessoal</p>
            {foreach $questoes as $questao}  
                {if $questao->getCategoria() == 0}
                    <div class="form-row" style="margin-top: 3%">
                        <div class="col-lg-1 col-sm-1 col-md-1 d-flex justify-content-end">
                            {$questaoQuestionarioDAO->getNumeroQuestao($versao, $questao->getId())}-
                        </div>
                        <div class="col-lg-10 col-sm-10 col-md-10">
                            <input type="text" name="edita_{$questao->getId()}" class="form-control" value="{$questao->getEnunciado()}">
                        </div>
                        <div style="margin-top: 2px" class="col-lg-1 col-sm-1 col-md-1">
                            <button style="margin-top: 2%" type="submit" name="exclui_{$questao->getId()}" ><a style=" color: darkred; margin-left: 2%"><small><i class="fa fa-trash"></i></small></a></button>                         
                        </div>
                    </div>
                {/if}
            {/foreach}
            <div class="form-row justify-content-center" style="margin-top: 3%">
                <div align="center" class="col-lg-12 col-sm-12 col-md-12" id="av_pessoal">
                    <!-- O input vai entrar aqui-->
                </div>
            </div>
            
            <!-- Botão de adicionar-->
            <div class="form-row justify-content-center" style="margin-top: 3%; margin-bottom: 3%">
                    <button class="btn btn-primary " type="button" name="av_pessoal" id="adicionar3">Adicionar</button>
            </div>
            <hr>
        {/if}

        {if $categoria == "1" || $categoria == "3"}
            <br>
            <p align="center" style=" font-weight: 750; font-size: 25px"> Avaliação da turma</p>
            {foreach $questoes as $questao}  
                {if $questao->getCategoria() == 1}
                    <div class="form-row" style="margin-top: 3%">
                        <div class="col-lg-1 col-sm-1 col-md-1 d-flex justify-content-end">
                            {$questaoQuestionarioDAO->getNumeroQuestao($versao, $questao->getId())}-
                        </div>
                        <div class="col-lg-10 col-sm-10 col-md-10">
                            <input type="text" name="edita_{$questao->getId()}" class="form-control" value="{$questao->getEnunciado()}">
                        </div>
                        <div style="margin-top: 2px" class="col-lg-1 col-sm-1 col-md-1">
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

            <!-- Botão de adicionar-->
            <div class="form-row justify-content-center" style="margin-top: 3%; margin-bottom: 3%">
                <button class="btn btn-primary " type="button" name="av_turma" id="adicionar2">Adicionar</button>
            </div>
            <hr>
        {/if}

        
        {if $categoria == "2" || $categoria == "3"}
            <br>
            <p align="center" style=" font-weight: 750; font-size: 25px"> Avaliação do professor</p>
            {foreach $questoes as $questao}  
                {if $questao->getCategoria() == 2}
                    <div class="form-row" style="margin-top: 3%">
                        <div class="col-lg-1 col-sm-1 col-md-1 d-flex justify-content-end">
                            {$questaoQuestionarioDAO->getNumeroQuestao($versao, $questao->getId())}-
                        </div>
                        <div class="col-lg-10 col-sm-10 col-md-10">
                            <input type="text" name="edita_{$questao->getId()}" class="form-control" value="{$questao->getEnunciado()}">
                        </div>
                        <div style="margin-top: 2px" class="col-lg-1 col-sm-1 col-md-1">
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
            <hr>

        {/if}
        
        
        <p align="center" style="margin-top: 2%; font-weight: 700; font-size: 25px"> Nome do Questionário</p>
        <div class="form-row justify-content-center" style="margin-top: 2%">
            <div class="col-lg-10 col-sm-10 col-md-10">
                <input type="text" name="novo_nome" class="form-control"  value="{$questionario->getNome()}">
            </div>
        </div>

        <div align="center"  class="col-lg-12 col-md-12">
            <nav aria-label="navigation" class="pagination justify-content-center">
                <button style="margin-top: 3%; margin-bottom: 2%; " class="btn btn-success " type="submit" name="salvar" >  Salvar alterações </button>
            </nav>
        </div>

    <hr>
    <div align="center"  class="col-lg-12 col-md-12">
        <nav aria-label="navigation" class="pagination justify-content-center">
            <button style="margin-top: 3%; margin-bottom: 2%;" class="btn btn-danger" type="submit" id="excluirQuestionario" name="excluirQuestionario"> Excluir questionario </button>
        </form>
        </nav>
    </div>

{/block}

{block name="javascript"}
    <script>
        const adicionar1 = document.getElementById("adicionar1"); //Professor
        const adicionar2 = document.getElementById("adicionar2"); //Turma
        const adicionar3 = document.getElementById("adicionar3"); //Pessoal

        const excluirQuestionario = document.getElementById("excluirQuestionario");

        const av_prof = document.getElementById("av_prof");
        const av_pessoal = document.getElementById("av_pessoal");
        const av_turma = document.getElementById("av_turma");

        var contador_1 = 0;
        var contador_2 = 0;
        var contador_3 = 0;

        excluirQuestionario.addEventListener("click", function( e ){
            var r = confirm("Você deseja excluir o questionário?");

            if( r == true ){
            //Executa a ação de excluir o questionário
            document.formulario.submit();

            } else {
            //Não faz nada

            }

        })

        adicionar1.addEventListener("click", function (event) {
        var input = document.createElement("input"); 
        contador_1 ++;
        input.name = "add_prof_" + contador_1;
        input.placeholder = " Digite o enunciado da questão";
        input.type = "text";
        input.class = "form-control";
        input.size = "126";
        input.style = "margin-top: 2%"; 

        av_prof.appendChild(input);

        });

        adicionar3.addEventListener("click", function (event) {
        var input = document.createElement("input"); 
        contador_3 ++;
        input.name = "add_pes_" + contador_3;
        input.placeholder = " Digite o enunciado da questão";
        input.type = "text";
        input.class = "form-control";
        input.size = "126";
        input.style = "margin-top: 2%"; 

        av_pessoal.appendChild(input);

        });

        adicionar2.addEventListener("click", function (event) {
        var input = document.createElement("input"); 
        contador_2 ++;
        input.name = "add_tur_" + contador_2;
        input.placeholder = " Digite o enunciado da questão";
        input.type = "text";
        input.class = "form-control";
        input.size = "126";
        input.style = "margin-top: 2%"; 

        av_turma.appendChild(input);

        });
    </script>
{/block}
