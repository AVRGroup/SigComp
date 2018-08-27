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
    <link rel="stylesheet" href="{base_url}/css/croppie.css"/>
    <link rel="stylesheet" href="{base_url}/css/style.css"/>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">


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
                    <li class="nav-item"><a class="nav-link" href="{path_for name="home"}">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="{path_for name="listCertificates"}">Certificados</a></li>
                    <li class="nav-item"><a class="nav-link" href="{path_for name="informacoesPessoais"}">Informações Pessoais</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administrador
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{path_for name="adminListUsers"}">Gerenciar Usuários</a>
                            <a class="dropdown-item" href="{path_for name="adminListReviewCertificates"}">Gerenciar Certificados</a>
                            <a class="dropdown-item" href="{path_for name="adminDataLoad"}">Carga de Dados</a>
                            <a class="dropdown-item" href="{path_for name="adminTest"}">Admin Test</a>
                            <a class="dropdown-item" href="{path_for name="checkPeriodos"}">Grades</a>
                            <a class="dropdown-item" href="{path_for name="assignMedals"}">Atribuir Medalhas</a>
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



<script>
    $(function() {
        $("input[type=file]").change(function () {

            var fieldVal = $(this).val();

            // Change the node's value by removing the fake path (Chrome)
            fieldVal = fieldVal.replace("C:\\fakepath\\", "");

            if (fieldVal !== undefined || fieldVal !== "") {
                $(this).next(".custom-file-label").attr('data-content', fieldVal);
                $(this).next(".custom-file-label").text(fieldVal);
            }
        });
    });

    //Contador de caracteres da pagina InformacoesPessoais
    var text_max = 50;
    $('#contador-mensagem').html(text_max + ' caracteres');

    $('#sobre-mim').keyup(function () {
        var text_length = $('#sobre-mim').val().length;
        var text_remaining = text_max - text_length;

        $('#contador-mensagem').html(text_remaining + ' caracteres');

        if(text_remaining <= 0){
            $('#contador-mensagem').html('Tamanho máximo atingido')
        }

    });
</script>

{block name=javascript}{/block}
</body>
</html>