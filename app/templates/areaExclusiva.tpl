{extends 'layout.tpl'}
{block name=content}
    <a href="{path_for name="login"}"><i style="color: black" class="fa fa-arrow-left"></i></a>
    <h3 class="text-center">Area Exclusiva</h3>
    <form class="login-form" method="post" action="{path_for name="login-exclusivo"}">
        {if isset($error)}
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {$error}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        {/if}

        <label for="login" class="sr-only">Login</label>
        <input type="text" id="login" name="login" class="form-control" placeholder="Login" required>

        <label for="senha" class="sr-only">Senha</label>
        <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>

        <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Entrar</button>
    </form>
{/block}