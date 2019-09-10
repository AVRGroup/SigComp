{extends 'layout.tpl'}
{block name=content}

    <h3 align="center">Informações Pessoais</h3>
    <hr>
    <div class="row container">
        <h5 class="col-md-6">Nome: {$usuario->getNome()}</h5>
        <h5 class="col-md-6 float-right">Matrícula: {$usuario->getMatricula()}</h5>
        <h5 class="col-md-6">Curso: {$usuario->getCurso()}</h5>
        <h5 class="col-md-6">E-mail: {$usuario->getEmail()}</h5>
        <h5 class="col-md-6">Indíce de Rendimento Acadêmico: {$usuario->getIra()|string_format:"%.2f"}</h5>
        <h5 class="col-md-6">Grade: {$usuario->getGrade()}</h5>

    </div>

    <h4 align="center" style="margin-top: 5%">Atualize seus dados</h4>
    <h6 align="center">Todas essas informações são opcionais</h6>

    <hr>
    {if isset($success)}
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p>{$success}</p>
        </div>
    {/if}

    {if isset($errors) && !empty($errors)}
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                {foreach $errors as $error}
                    <li>Erro na rede {$error}, por favor verifique se o link está no formato correto</li>
                {/foreach}
            </ul>
        </div>
    {/if}

    <form method="post">
        <div class="form-row">
            <div class="col-8">
                <label for="email">E-mail</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu e-mail" value="{$usuario->getEmail()}">
            </div>

        </div>

        <div class="custom-control custom-checkbox" style="margin-top: 2%">
            <input id="nome-real" type="checkbox" name="nome_real" class="custom-control-input" {$checked}>
            <label class="custom-control-label" for="nome-real">Desejo que meu nome não seja mostrado</label>
        </div>

        <div class="form-row" style="margin-top: 3%">
            <div class="col-6">
                <label for="facebook">Facebook</label>
                <input type="text" name="facebook" placeholder="https://facebook.com/seu.perfil" class="form-control" value="{$usuario->getFacebook()}">
            </div>

            <div class="col-6">
                <label for="instagram">Instagram</label>
                <input type="text" name="instagram" placeholder="https://instagram.com/seu.perfil" class="form-control" value="{$usuario->getInstagram()}">
            </div>
        </div>

        <div class="form-row" style="margin-top: 3%">
            <div class="col-6">
                <label for="linkedin">LinkedIn</label>
                <input type="text" name="linkedin" placeholder="https://linkedin.com/seu.perfil" class="form-control" value="{$usuario->getLinkedin()}">
            </div>

            <div class="col-6">
                <label for="lattes">Lattes</label>
                <input type="text" name="lattes" placeholder="https://lattes.com/seu.perfil" class="form-control" value="{$usuario->getLattes()}">
            </div>
        </div>


        <h5 align="center" style="margin-top: 3%">Sobre mim</h5>
        <textarea style="margin-left: 29.5%" name="sobre_mim"  id="sobre-mim" cols="50" rows="7" placeholder="Maximo 50 caracteres" >{$usuario->getSobreMim()}</textarea>
        <small id="contador-mensagem"></small>
        <hr>

        <button class="btn btn-primary" type="submit">Atualizar</button>

    </form>


{/block}

