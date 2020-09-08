{extends 'layout.tpl'}
{block name=content}
    <p align="center" style="font-size: 30px; font-weight: 600">Você está criando um novo qustionário!</p>

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

    <form name="formulario" method="POST" action="{base_url}/admin/store-new-questionario">

        <p align="center" style="font-size: 25px"> Avaliação pessoal </p>
            <div class="form-row justify-content-center" style="margin-top: 3%">
                <div align="center" class="col-lg-12 col-sm-12 col-md-12" id="av_pessoal">
                    <!-- O input vai entrar aqui-->
                </div>
            </div>

            <div class="form-row justify-content-center" style="margin-top: 3%; margin-bottom: 3%">
                <button class="btn btn-primary " type="button" name="av_pessoal" id="adicionar1">Adicionar</button>
            </div>
        <hr>

        <p align="center" style="font-size: 25px"> Avaliação do professor </p>
            <div class="form-row justify-content-center" style="margin-top: 3%">
                <div align="center" class="col-lg-12 col-sm-12 col-md-12" id="av_prof">
                    <!-- O input vai entrar aqui-->
                </div>
            </div>

            <div class="form-row justify-content-center" style="margin-top: 3%; margin-bottom: 3%">
                <button class="btn btn-primary " type="button" name="av_prof" id="adicionar2">Adicionar</button>
            </div>
        <hr>

        <p align="center" style="font-size: 25px"> Avaliação da turma </p>
            <div class="form-row justify-content-center" style="margin-top: 3%">
                <div align="center" class="col-lg-12 col-sm-12 col-md-12" id="av_turma">
                    <!-- O input vai entrar aqui-->
                </div>
            </div>

            <div class="form-row justify-content-center" style="margin-top: 3%; margin-bottom: 3%">
                <button class="btn btn-primary " type="button" name="av_turma" id="adicionar3">Adicionar</button>
            </div>
        <hr>

        <p align="center" style="margin-top: 2%; font-weight: 700; font-size: 25px"> Nome do Questionário</p>
        <div class="form-row justify-content-center" style="margin-top: 2%">
            <div class="col-lg-10 col-sm-10 col-md-10">
                <input type="text" name="newNameQuestionario" class="form-control" placeholder="Digite o nome do questionário" ></input>
            </div>
        </div>

        <div align="center"  class="col-lg-12 col-md-12">
            <nav aria-label="navigation" class="pagination justify-content-center">
                <button style="margin-top: 3%; margin-bottom: 2%; " class="btn btn-success " type="submit" name="salvar" >  Salvar alterações </button>
            </nav>
        </div>
    
    
    </form>

{/block}
{block name="javascript"}

    <script>
        const adicionar1 = document.getElementById("adicionar1"); //Pessoal
        const adicionar2 = document.getElementById("adicionar2"); //Professor
        const adicionar3 = document.getElementById("adicionar3"); //Turma

        const excluirQuestionario = document.getElementById("excluirQuestionario");

        const av_pessoal = document.getElementById("av_pessoal");
        const av_prof = document.getElementById("av_prof");
        const av_turma = document.getElementById("av_turma");

        var contador_1 = 0;
        var contador_2 = 0;
        var contador_3 = 0;


        adicionar1.addEventListener("click", function (event) {
            var input = document.createElement("input"); 
            contador_1++;
            input.name = "add_pess_" + contador_1;
            input.placeholder = "Digite o enunciado da questão";
            input.type = "text";
            input.class = "form-control";
            input.size = "126";
            input.style = "margin-top: 2%"; 

            av_pessoal.appendChild(input);
        });

        adicionar2.addEventListener("click", function (event) {
            var input = document.createElement("input"); 
            contador_3++;
            input.name = "add_prof_" + contador_3;
            input.placeholder = " Digite o enunciado da questão";
            input.type = "text";
            input.class = "form-control";
            input.size = "126";
            input.style = "margin-top: 2%"; 

            av_prof.appendChild(input);
        });

        adicionar3.addEventListener("click", function (event) {
            var input = document.createElement("input"); 
            contador_2 ++;
            input.name = "add_turma_" + contador_2;
            input.placeholder = " Digite o enunciado da questão";
            input.type = "text";
            input.class = "form-control";
            input.size = "126";
            input.style = "margin-top: 2%"; 

            av_turma.appendChild(input);
        });
    </script>
{/block}