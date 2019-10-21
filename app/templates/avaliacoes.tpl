{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Avaliação </h2>

<hr>
<br>
    <div class="dropdown" align="center">
    <p align="center" class="font-italic" style="font-size: 18px;"> (Opção dropdown) </p>
      <button class="btn btn-primary dropdown-toggle font-italic" type="button" id="dropdownMenuButton" data-toggle="dropdown" 
      data-boundary="viewport"  aria-haspopup="true" aria-expanded="false"> Selecione uma disciplina
      </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item col-md-6 col-xs-12" href="#">DCC013 - Estrutura de dados</a>
            <a class="dropdown-item col-md-6 col-xs-12" href="#">DCC160 - Lógica e fundamentos da computação</a>
            <a class="dropdown-item col-md-6 col-xs-12" href="#">MAT154 - Cálculo I</a>
            <a class="dropdown-item col-md-6 col-xs-12" href="#">DCC120 - Laboratório de programação</a>
            <a class="dropdown-item col-md-6 col-xs-12" href="#">CAD076 - Princípios de administração</a>
        </div>
    </div>
    <br>

    <hr>
            <p align="center" class="font-italic" style="font-size: 18px;"> (Opção com botões) </p>
            <p align="center" class="font-italic" style="font-size: 24px;"> Selecione uma disciplina </p>

            <div align="center" class="row container-fluid ml-lg-0" style="font-size: 17px;" >
                <form action="form-action.php" method="post" class="form-group col-lg-12 ml-lg-0" align="left">
                    <br>
                    <p >
                        <input class="offset-md-4" type="radio" name="disciplina" value="dcc013">   DCC013 - Estrutura de dados
                    </p>
                    <p>
                        <input class="offset-md-4" type="radio" name="disciplina" value="dcc160"/>  DCC160 - Lógica e fundamentos da computação
                    </p>
                    <p>
                        <input class="offset-md-4" type="radio" name="disciplina" value="mat154"/>  MAT154 - Cálculo I
                    </p>
                    <p>
                        <input class="offset-md-4" type="radio" name="disciplina" value="DCC120"/>  DCC120 - Laboratório de programação
                    </p>
                    <p>
                        <input class="offset-md-4" type="radio" name="disciplina" value="CAD076"/>  CAD076 - Princípios de administração
                    </p>
                </form>
            </div>
                    <p align="center">
                    <br>
                        <button  type="submit" class="btn btn-primary btn-lg"> Selecionar </button>
                    </p>

{/block}