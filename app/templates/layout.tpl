<!doctype html>
<html lang="pt" class="h-100">
<head>
    <title>Gameficação</title>
    <meta charset="utf-8">
    <meta name="robots" content="index,follow" />
    <meta name="Description" content="Gameficação" />
    <meta name="Keywords" content="Gameficação" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{base_url}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{base_url}/css/style.css"/>
</head>

<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{path_for name="home"}">Gameficação</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                {if $loggedUser != null}
                    <li class="nav-item">
                        <a class="nav-link" href="{path_for name="home"}">Início</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Exemplo
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                {else}
                <li class="nav-item">
                    <a class="nav-link" href="{path_for name="about"}">Sobre</a>
                </li>
                {/if}
            </ul>
            {if $loggedUser != null}
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Olá, {$loggedUser->getPrimeiroNome()}!
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{path_for name="listProfiles"}">Trocar Perfil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{path_for name="logout"}">Sair</a>
                </div>
            </div>
            {/if}
        </div>
    </div>
</nav>

<div class="container content">
    {block name=content}{/block}
</div>

<!-- jQuery -->
<script src="{base_url}/js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap js -->
<script src="{base_url}/js/bootstrap.min.js"></script>
<!-- Fontaewsome -->
<script src="{base_url}/js/fontawesome-all.min.js"></script>

{block name=javascript}{/block}
</body>
</html>