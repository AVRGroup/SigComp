{extends 'layout.tpl'}
{block name=content}

    <h4 align="center">Informações Pessoais</h4>
    <hr>

    <div class="row container">
        <h5 class="col-md-6">Nome: {$usuario->getNome()}</h5>
        <h5 class="col-md-6 float-right">Matrícula: {$usuario->getMatricula()}</h5>
        <h5 class="col-md-6">Curso: {$usuario->getCurso()}</h5>
        <h5 class="col-md-6">E-mail: {$usuario->getEmail()}</h5>
        <h5 class="col-md-6">Indíce de Rendimento Acadêmico: {$usuario->getIra()|string_format:"%.2f"}</h5>

    </div>

    <h4 align="center" style="margin-top: 5%">Atualize seus dados</h4>
    <hr>

    <form action="">
        <div class="form-row">
            <div class="col-6">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail">
            </div>
            <div class="col-6">
                <label for="nickname">Nickname</label>
                <input type="text" class="form-control" id="text" placeholder="Digite seu nickname">
            </div>
        </div>

        <div class="custom-control custom-checkbox" style="margin-top: 2%">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1">Desejo que meu nickname seja mostrado em vez do meu nome</label>
        </div>

        <div class="form-row" style="margin-top: 3%">
            <div class="col-6">
                <label for="facebook">Facebook</label>
                <input type="text" placeholder="Digite seu perfil no Facebook" class="form-control">
            </div>

            <div class="col-6">
                <label for="instagram">Instagram</label>
                <input type="text" placeholder="Digite seu perfil no Instagram" class="form-control">
            </div>
        </div>

        <div class="form-row" style="margin-top: 3%">
            <div class="col-6">
                <label for="linkedin">LinkedIn</label>
                <input type="text" placeholder="Digite seu perfil no Linkedin" class="form-control">
            </div>

            <div class="col-6">
                <label for="lattes">Lattes</label>
                <input type="text" placeholder="Digite seu perfil no Lattes" class="form-control">
            </div>
        </div>


        <h5 align="center" style="margin-top: 3%">Sobre mim</h5>
        <textarea style="margin-left: 29.5%" name="sobre-mim"  id="sobre-mim" cols="50" rows="7" placeholder="Maximo 50 caracteres"></textarea>
        <small id="contador-mensagem"></small>
        <hr>

        <button class="btn btn-primary" type="submit">Atualizar</button>

    </form>


{/block}

