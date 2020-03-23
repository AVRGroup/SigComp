<!doctype html>
<html lang="pt" class="h-100">
<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131900774-1"></script>

    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-131900774-1');
    </script>

    <title>SigComp - Sistema Gamificado</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow" />
    <meta name="Description" content="Gamificação" />
    <meta name="Keywords" content="Gamificação" />
    <link rel="icon" href="{base_url}/img/b_season_finale.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{base_url}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{base_url}/css/croppie.css"/>
    <link rel="stylesheet" href="{base_url}/css/style.css"/>
    <link rel="stylesheet" href="{base_url}/css/theme.bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
</head>

<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{path_for name="home"}">Gamificação</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                {if $loggedUser != null}

                    {if $loggedUser->isAluno()}

                        <div class="dropdown">

                            {if sizeof($notificacoes)==0 }
                                <button class="btn btn-secondary notificacao-sem-amigo dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                </button>
                            {else}
                                <button class="btn btn-secondary notificacao-com-amigo dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                </button>
                            {/if}

                            <div class="dropdown-menu scrollable" aria-labelledby="dropdownMenuButton">
                                {foreach $notificacoes as $notificacao}
                                      <li class="lista-notificacoes">
                                          {$notificacao['nome']}
                                          <div style="margin-top: 15px">
                                              <a href="{path_for name="aceitarAmizade" data=["id-remetente" => $notificacao['id'], "id-destinatario" => $loggedUser->getId()]}" class="btn btn-primary">Aceitar</a>
                                              {*<a href="{path_for name="recusarAmizade" data=["id-remetente" => $notificacao['id'], "id-destinatario" => $loggedUser->getId()]}" class="btn btn-danger">Recusar</a>*}
                                          </div>
                                      </li>
                                      <hr>
                                  {foreachelse}
                                      <li class="lista-notificacoes-vazia">Não há convites pendentes</li>
                                  {/foreach}
                            </div>

                        </div>

                        <li class="nav-item"><a class="nav-link" href="{path_for name="home"}">Início</a></li>
                    {/if}

                    {if $loggedUser->isAdmin() || $loggedUser->isCoordenador() }
                        <li class="nav-item"><a class="nav-link" href="{path_for name="adminDashboard"}">Início</a></li>
                    {/if}

                    {if $loggedUser->isBolsista()}
                        <li class="nav-item"><a class="nav-link" href="{path_for name="adminListReviewCertificates"}">Gerenciar Certificados</a></li>
                    {/if}

                    <li class="nav-item"><a class="nav-link" href="{path_for name="verOportunidades"}">Ver Oportunidades</a></li>

                    {if !$loggedUser->isBolsista()}
                        {if $loggedUser->isAluno()}
                            <li class="nav-item"><a class="nav-link" href="{path_for name="listaAmigos" data=["id" => $loggedUser->getId()]}">Lista de Amigos</a></li>
                        {/if}
                        <li class="nav-item"><a class="nav-link" href="{path_for name="listCertificates"}">Certificados</a></li>

                        <li class="nav-item"><a class="nav-link" href="{path_for name="informacoesPessoais"}">Informações Pessoais</a></li>
                        {*<li class="nav-item"><a class="nav-link" href="{path_for name="forum"}">Fórum</a></li>*}
                        
                        <li class="nav-item"><a class="nav-link" href="{path_for name="avaliacoes"}"> Avaliação </a></li>
                        
                        {if $estaImpersonando == true}
                            <li class="nav-item" style="background-color: #e74c3c;"><a class="nav-link" style="color:black" href="{path_for name="sairImpersonar"}">SAIR DO USUARIO</a></li>
                        {/if}

                        {if $loggedUser->isAluno()}
                            <li class="nav-item"><a class="nav-link" href="{path_for name="privacidade"}">Política de Privacidade</a></li>
                        {/if}

                        {if $loggedUser->isAdmin()}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Administrador
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="{path_for name="adminDashboard"}">Dashboard</a>
                                    <a class="dropdown-item" href="{path_for name="forum"}">Fórum</a>
                                    <a class="dropdown-item" href="{path_for name="adminListUsers"}">Gerenciar Usuários</a>
                                    <a class="dropdown-item" href="{path_for name="adminListReviewCertificates"}">Gerenciar Certificados</a>
                                    <a class="dropdown-item" href="{path_for name="assignMedals"}">Atribuir Medalhas</a>
                                    <a class="dropdown-item" href="{path_for name="editCoordenacao"}">Coordenadores</a>
                                    <a class="dropdown-item" href="{path_for name="questionarios"}">Edição questionário</a>  
                                    <a class="dropdown-item" href="{path_for name="adminData"}">Carga de Dados</a>
                                    <div class="dropdown-submenu">
                                        <a class="nav-link dropdown-toggle submenu" style="  color: black; padding: .25rem 1.5rem;" href="#"
                                           id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Relatorios
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{path_for name="relatorioPeriodizado"}">Alunos Periodizados</a>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        {/if}

                        {if $loggedUser->isCoordenador()}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ferramentas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="{path_for name="adminListUsers"}">Gerenciar Usuários</a>
                                    <a class="dropdown-item" href="{path_for name="adminListReviewCertificates"}">Gerenciar Certificados</a>

                                    <a class="dropdown-item" href="{path_for name="adminData"}">Carga de Dados</a>
                                    <div class="dropdown-submenu">
                                        <a class="nav-link dropdown-toggle submenu" style="  color: black; padding: .25rem 1.5rem;" href="#"
                                           id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Relatorios
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{path_for name="relatorioPeriodizado"}">Alunos Periodizados</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        {/if}

                    {/if}

                    {if !$loggedUser->isAluno()}
                        <li class="nav-item">
                            <a class="nav-link" href="{path_for name="logout"}">Sair</a>
                        </li>
                    {/if}
                {/if}

                {if  $loggedUser == null}
                    <li class="nav-item">
                        <a class="nav-link" href="{path_for name="about"}">Sobre</a>
                    </li>
                {/if}
            </ul>

            {if isset($loggedUser) && $loggedUser->isAluno()}
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

<!-- Table Sorter -->
<script src="{base_url}/js/jquery.tablesorter.combined.js"></script>

<!-- Popper -->
<script src="{base_url}/js/popper.min.js"></script>

<!-- Bootstrap js -->
<script src="{base_url}/js/bootstrap.min.js"></script>

<!-- Fontaewsome -->
<script src="{base_url}/js/fontawesome-all.min.js"></script>


<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>


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

    $(document).ready(function(){
        $('.dropdown-submenu a.submenu').on("click", function(e){
            $(this).next('div').toggle();
            e.stopPropagation();
            e.preventDefault();
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

    //Fim do contador de caracteres da pagina InformacoesPessoais

    $(function () {
        $('[data-toggle="popover"]').popover()
    });

    //Botao da pargina de certificados para adicionar mais inputs
    $(document).ready(function() {
        var max_fields      = 2;
        var wrapper         = $(".novos-botoes");
        var add_button      = $(".add-input");

        var x = 0;
        $(add_button).click(function(e){
            e.preventDefault();
            if(x < max_fields){
                var inicio = 'data_inicio'+x;
                var fim = 'data_fim'+x;
                x++;
                $(wrapper).append('<div>' +
                    '<label style="margin-top: 3%" for="data-inicio">Digite a data de inicio do certificado</label>'+
                    '<input type="date" class="form-control col-8" name="data_inicio'+x+'"/>' +
                    '<label style="margin-top: 3%" for="data-inicio">Digite a data de término do certificado</label>'+
                    '<input type="date" class="form-control col-8" name="data_fim'+x+'"/>' +
                    '<hr>' +
                    '</div>')
            }
            else
            {
                alert('Você chegou no limite de períodos')
            }
        });


        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
    //Fim do botão para adicionarm mais inputs

    //Grafico de acessos
    google.charts.load('current', { 'callback': drawChart ,'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart3D);

    var countNaoLogaram = $('#countNaoLogaram').val();
    var countLogaram = $('#countLogaram').val();

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Estado', 'Quantidade'],
            ['Acessaram', countLogaram / 10 * 10],
            ['Não Acessaram', countNaoLogaram / 10 * 10]
        ]);

        var options = {
            title :'Número de Alunos que Acessaram ao menos uma vez',
            width:700, height:400,
            sliceVisibilityThreshold: 0,
            backgroundColor: '#fafafa',
            pieSliceText: 'value',
            legend: {
                position: 'labeled',
                textStyle: {
                    fontName: 'monospace',
                    fontSize: 12
                }
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }

    function drawChart3D() {
        var data = google.visualization.arrayToDataTable([
            ['Estado', 'Quantidade'],
            ['Acessaram', countLogaram / 10 * 10],
            ['Não Acessaram', countNaoLogaram / 10 * 10]
        ]);

        var options = {
            title :'Número de Alunos que Acessaram',
            width:700, height:400,
            sliceVisibilityThreshold: 0,
            is3D: true,
            backgroundColor: '#fafafa',
            legend: {
                position: 'top',
                textStyle: {
                    fontName: 'monospace',
                    fontSize: 12
                }
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart-3d'));
        chart.draw(data, options);
    }
    //Fim do grafico de acessos

    $(function() {
        $("#tabela").tablesorter();
    });
</script>

{block name=javascript}{/block}
</body>
</html>