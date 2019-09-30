{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Login</h3>
    <form class="login-form" method="post">
        {if isset($error)}
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {$error}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        {/if}
        <label for="inputEmail" class="sr-only">CPF</label>
        <input type="text" id="cpf" name="cpf" class="form-control" placeholder="CPF" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Senha" required="">
        <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Entrar</button>
    </form>
{/block}