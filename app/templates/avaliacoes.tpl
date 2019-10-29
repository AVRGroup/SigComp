{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Avaliação </h2>
    <!-- 01#!/79awQxVp -->
    <hr>
            <p align="center" class="font-italic" style="font-size: 24px;"> Selecione uma disciplina </p>

    <div class="row container">
        <div align="center" >
            <a href="{path_for name="avaliacaoPage01"}" class="btn btn-primary btn-lg active col-lg-6 col-sm-12 col-md-12" style="margin-top: 1%" role="button" aria-pressed="true">DCC013 - Estrutura de dados</a>
            <a href="#" class="btn btn-primary btn-lg active col-lg-6 col-sm-12 col-md-12" style="margin-top: 1%" role="button" aria-pressed="true">DCC160 - Lógica e fundamentos da computação</a>
            <a href="#" class="btn btn-primary btn-lg active col-lg-6 col-sm-12 col-md-12" style="margin-top: 1%" role="button" aria-pressed="true">MAT154 - Cálculo I</a>
            <a href="#" class="btn btn-primary btn-lg disabled col-lg-6 col-sm-12" style="margin-top: 1%" tabindex="-1" role="button" aria-disabled="true">DCC120 - Laboratório de programação</a>
            <a href="#" class="btn btn-primary btn-lg disabled col-lg-6 col-sm-12" style="margin-top: 1%" tabindex="-1" role="button" aria-disabled="true">CAD076 - Princípios de administração</a>
        </div>
    </div>

{/block}