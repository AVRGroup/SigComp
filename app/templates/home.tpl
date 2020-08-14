
{extends 'layout.tpl'}
{block name=content}
    <div class="container">
        <h4 class="text-center">{if $usuario->getNomeReal()}{$usuario->getNome()}{else}Usuario {$usuario->getId()}{/if}</h4>

        <div class="row">
            <div class="col-sm-4 col-md-4 col-lg-3 col-xs-12">
                <div class="text-center">
                    <div class="changePic">
                        <img src="{base_url}/{if $usuario->getFoto()}upload/{$usuario->getFoto()}{else}img/silhueta.jpg{/if}"
                             class="img-thumbnail" alt="{$usuario->getNome()}" width="190" height="190">
                    </div>

                    <div class="align-content-lg-center">

                        {if $usuario->getFacebook() == null}
                            <img src="{base_url}/img/fb_preto.png" class="img-thumbnail" alt="Facebook" width="42" height="42">
                        {else}
                            <a href="{$usuario->getFacebook()}" target="_blank"><img src="{base_url}/img/fb.png" class="img-thumbnail" alt="Facebook" width="42" height="42"></a>
                        {/if}

                        {if $usuario->getInstagram() == null}
                            <img src="{base_url}/img/instagram_preto.jpg" class="img-thumbnail" alt="Instagram" width="42" height="42">
                        {else}
                            <a href="{$usuario->getInstagram()}" target="_blank"><img src="{base_url}/img/instagram.jpg" class="img-thumbnail" alt="Instagram" width="42" height="42"></a>
                        {/if}

                        {if $usuario->getLinkedin() == null}
                            <img src="{base_url}/img/linkedin_preto.png" class="img-thumbnail" alt="LinkedIn" width="42" height="42">
                        {else}
                            <a href="{$usuario->getLinkedin()}" target="_blank"><img src="{base_url}/img/linkedin.png" class="img-thumbnail" alt="LinkedIn" width="42" height="42"></a>
                        {/if}

                        {if $usuario->getLattes() == null}
                            <img src="{base_url}/img/lattes_preto.png" class="img-thumbnail" alt="Lattes" width="42" height="42">
                        {else}
                            <a href="{$usuario->getLattes()}" target="_blank"><img src="{base_url}/img/lattes.png" class="img-thumbnail" alt="Lattes" width="42" height="42"></a>
                        {/if}

                    </div>

                    <div class="sobre-mim">
                        <h5>Sobre mim</h5>
                        <textarea name="sobre_mim" id="sobre-mim"  disabled rows="6" maxlength="100" style="width:100%">{$usuario->getSobreMim()}</textarea>
                    </div>

                    <div><span style="font-size: 12px">Grade: {$usuario->getGrade()} | Periodo {$periodoAtual}</span> </div>

                </div>
            </div>

            <div class="col-lg-9 col-xs-12 text-center">
                <div class="col-sm-2 col-md-2 col-xs-2 float-right">
                    <button type="button" class="btn btn-danger btn-circle" data-toggle="popover"  data-placement="top"  data-trigger="focus"
                            title="Informações"
                            data-content="Esse gráfico representa seu desempenho nas áreas de conhecimento dentro do seu curso. Para saber quais disciplinas
                            afetam quais áreas, clique <a href='{base_url}/info-radar-chart'>aqui</a>">
                        ?
                    </button>
                </div>

                <canvas id="radar"></canvas>

                <div class="mt-3 d-flex justify-content-around flex-wrap">
                    {if isset($visaoAmigo) && $visaoAmigo}
                        <div class="custom-tooltip">
                            <button onclick="setRadarSobrepostoAmigo()" class="btn btn-success">Comparar com suas notas</button>
                            <span class="custom-tooltiptext">Compare as suas notas (em verde) com as do seu amigo</span>
                        </div>
                    {else}
                    <div>
                        <div class="custom-tooltip" style="margin-top: 2%">
                            <button onclick="setRadarRealizadas()" class="btn btn-primary col-sm-12 col-md-12"
                                    data-toggle="popover" data-placement="top"  data-trigger="hover"
                                    data-content="Esse grafico leva em conta apenas as disciplinas que você já realizou"
                            >
                                Disciplinas já realizadas
                            </button>
                        </div>
                        <div class="custom-tooltip" style="margin-top: 2%">
                            <button onclick="setRadarTodas()" class="btn btn-success col-sm-12 col-md-12"
                                    data-toggle="popover" data-placement="top"  data-trigger="hover"
                                    data-content="Esse gráfico mostra como estão suas notas levando em conta todas as disciplinas da grade. As que ainda não foram realizadas têm nota zero"
                            >
                                Todas as disciplinas
                            </button>
                        </div>
                        <div class="custom-tooltip" style="margin-top: 2%">
                            <button onclick="setRadarSobreposto()" class="btn btn-radar-sobreposto col-sm-12 col-md-12"
                                    data-toggle="popover" data-placement="top"  data-trigger="hover"
                                    data-content="Sobreponha os dois gráficos para conseguir uma melhor comparação"
                            >
                                    Sobreposto
                            </button>
                        </div>
                    </div>
                    {/if}
                </div>

            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-9">
                <p></p>
                <div class="row">
                    <h4 class="text-center col-11">Quadro de medalhas</h4>
                        <button type="button" class="btn btn-success btn-circle" data-toggle="popover"  data-placement="top"  data-trigger="focus"
                                title="Informações"
                                data-content="As medalhas são uma forma de você guardar suas realizações durante o curso! Algumas são atribuídas ao final
                                de cada semestre (como as de IRA) e outras ao registrar seus certificados no sistema (como as de Monitoria, GET...)">
                            ?
                        </button>
                </div>
                <ul class="nav nav-tabs" id="badgesTab" role="tablist">
                    {if $usuario->getTipo() !=1 }
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" id="current-tab" role="tab" href="#current">Medalhas Conquistadas</a>
                        </li>
                    {/if}
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="possible-tab" role="tab" href="#possible">Medalhas Possíveis</a>
                    </li>
                </ul>
                <div class="tab-content" id="badgesTabContent">
                    {if $usuario->getTipo()!=1 && $usuario->getTipo()!=2}
                        <div class="tab-pane fade show active" id="current" role="tabpanel" aria-labelledby="current-tab">
                            <div class="row justify-content-start">

                                {$novaLinha = 1}
                                {$numMedalhas = 0}
                                {$i=0}
                                {$auxI = 0}

                                {foreach $medalhas as $medal}
                                    {$numMedalhas = $numMedalhas + 1}
                                {/foreach}

                                {if $medalhas[0]['medalha'] != null}
                                    {while $novaLinha === 1}

                                        {$novaLinha = 0}
                                        {while $i < $numMedalhas}

                                            {if $numMedalhas >= 1}
                                                <div class="col-1.5">
                                                    <div class="img-thumbnail altura-medalha" style="max-width: 90px;">
                                                        <img src="{base_url}/img/{$medalhas[$i].imagem}" class="img-fluid"">

                                                        <div class="caption">
                                                            <p class="text-center"><small class="legenda-imagem">{$medalhas[$i].nome}</small></p>
                                                        </div>
                                                    </div>
                                                    {$i = $i + 1}
                                                    {$auxI = $auxI + 1}
                                                </div>
                                            {else}
                                                <h6 style="margin: 30px;" class="text-center">Você ainda não possui nenhuma medalha</h6>
                                            {/if}

                                            {if $auxI > 6}
                                                {$novaLinha = 1}
                                                {$auxI = 0}
                                                {break}
                                            {/if}
                                        {/while}

                                    {/while}

                                {else}
                                    <p class="text-center" style="margin: 20px">Você ainda não possui nenhuma medalha. Dê uma olhada em quais medalhas são possíveis de alcançar na aba de 'Medalhas Possíveis'</p>
                                {/if}

                            </div>
                        </div>
                    {/if}

                    <div class="tab-pane fade" id="possible" role="tabpanel" aria-labelledby="possible-tab">
                        <div class="row justify-content-start">
                            {$novaLinha = 1}
                            {$numMedalhas = 0}
                            {$i=0}
                            {$auxI = 0}

                            {foreach $todasMedalhas as $medal}
                                {$numMedalhas = $numMedalhas + 1}
                            {/foreach}

                            {while $novaLinha === 1}
                                {$novaLinha = 0}
                                {while $i < $numMedalhas}
                                    <div class="col-1.5">
                                        <div class="img-thumbnail altura-medalha" style="max-width: 90px;">
                                            <img src="{base_url}/img/{$todasMedalhas[$i].imagem}" class="img-fluid">
                                            <div class="caption">
                                                <p class="text-center"><small class="legenda-imagem">{$todasMedalhas[$i].nome}</small></p>
                                            </div>
                                        </div>
                                        {$i = $i + 1}
                                        {$auxI = $auxI + 1}
                                    </div>
                                    {if $auxI > 8}
                                        {$novaLinha = 1}
                                        {$auxI = 0}
                                        {break}
                                    {/if}
                                {/while}
                            {/while}

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {if $usuario->getIra() > 0}
            <div style="height: 100px; margin-top: 40px" >
                <canvas id="percentilIra"></canvas>
            </div>
        {else}
            <div class="aviso-ira">
                <p>Seu Índice de Rendimento Acadêmico será computado ao finalizar o periodo, passando em ao menos uma matéria</p>
            </div>
        {/if}

        <div class="row">
            <div class="col-sm-6 col-md-6 col-xs-6" style="margin-top: 1.8%">
                <div class="row">
                    <h4 class="text-center col-sm-10 col-md-10 col-xs-10">Melhor IRA Geral</h4>
                    <div class="col-sm-2 col-md-2 col-xs-2">
                        <button type="button" class="btn btn-danger btn-circle" data-toggle="popover"  data-placement="top"  data-trigger="focus"
                                title="Informações"
                                data-content="Esse é o IRA geral, considerando todos os seus períodos. São considerados apenas os alunos ativos no curso">
                            ?
                        </button>
                    </div>
                </div>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">IRA</th>
                    </tr>
                    </thead>
                    <tbody>
                    {$i = 1}
                    {foreach $top10Ira as $user}
                        <tr>
                            <th scope="row">{$i++}</th>
                            <td>{if $user->getNomeReal()}
                                    {$user->getNomeAbreviado()}
                                {else}
                                    USUARIO {$user->getId()}
                                {/if}
                            </td>
                            <td>{$user->getIra()|string_format:"%.2f"}</td>
                        </tr>
                    {/foreach}
                </table>
            </div>
            <div class="col-sm-6 col-md-6 col-xs-6" style="margin-top: 1.8%">
                <div class="row">
                    <div class=" col-sm-10 col-md-10 col-xs-10">
                        <h4 class="text-center">Melhor IRA em {substr_replace($periodoPassado, '.', 4, 0)}</h4>
                    </div>
                    <div class="col-sm-2 col-md-2 col-xs-2">
                        <button type="button" class="btn btn-danger btn-circle" data-toggle="popover"  data-placement="top"  data-trigger="focus"
                                title="Informações"
                                data-content="Esse é o IRA somando as notas apenas do ultimo periodo. São considerados aqueles que fizeram
                                              pelo menos 4 matérias dos departamentos DCC, MAT, FIS ou EST">
                            ?
                        </button>
                    </div>
                </div>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">IRA</th>
                    </tr>
                    </thead>
                    <tbody>
                    {$i = 1}
                    {foreach $top10IraPeriodoPassado as $user}
                        <tr>
                            <th scope="row">{$i++}</th>
                            <td>{if $user->getNomeReal()}{$user->getNomeAbreviado()}{else}USUARIO {$user->getId()}{/if}</td>
                            <td>{$user->getIraPeriodoPassado()|string_format:"%.2f"}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>

        <input id="posicao" type="hidden" value="{$posicaoGeral}">

        <hr>
        {if isset($isAdmin) && $isAdmin}
            <a href="{path_for name="exportPDF" data=["id" => $usuario->getId()]}" class="btn btn-danger">Certificados do Aluno</a>
        {else}

            {if !isset($naoBarraPesquisa)}
                <h4 class="text-center">Amigos</h4> <h6 class="text-center">Digite o nome da pessoa no campo abaixo para adicioná-lo como amigo!</h6>

                <div align="center">
                    <form class="form-row justify-content-center col-md-10" method="post" style="margin-top: 30px;">
                        <input id="pesquisa" name="pesquisa" type="text" class="form-control col-md-11 col-sm-10 col-xs-10" placeholder="Pesquisar">
                            <button style="margin-left: 1%; margin-top: 2%; width: 200px" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </form>
                </div>

                {if isset($usuariosPesquisados)}
                    <table id="friends" style="margin-top: 4%" class="table table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $usuariosPesquisados as $user}
                            <tr>
                                <td>{$user['nome']}</td>

                                {if $user['estado'] == 'nao enviado'}
                                    <td><a href="{path_for name="conviteAmizade" data=["id-remetente" => $usuario->getId(), "id-destinatario" => $user['id']]}" class="btn btn-primary">Adicionar</a></td>
                                {/if}

                                {if $user['estado'] == 'aceito'}
                                    <td><p class="text-success">Vocês já são amigos</p></td>
                                {/if}

                                {if $user['estado'] == 'pendente'}
                                    <td><p class="text-warning">Convite pendente</p></td>
                                {/if}

                            </tr>
                            {foreachelse}
                            <tr>
                                <td scope="row" colspan="4" class="text-center">Nenhum usuário encontrado!</td>
                            </tr>
                        {/foreach}
                    </table>
                {/if}
            {/if}
        {/if}

    </div>

{/block}
{block name=javascript}
    <script src="{base_url}/js/croppie.js"></script>
    <script src="{base_url}/js/exif.js"></script>


    <script>
        var element = document.getElementById('percentilIra');
        if(element) {
            var ctx = element.getContext('2d')

            ctx.height = 200;

            var posicao = document.getElementById('posicao').value;

            var chart = new Chart(ctx, {
                type: 'horizontalBar',

                data: {
                    labels: ['Sua Posição'],
                    datasets: [{
                        label: 'Seu IRA é maior que ' + posicao + '% dos alunos do seu curso',
                        data: [posicao, 100, 0],
                        backgroundColor: [
                            'rgba(41, 128, 185, 0.4)'
                        ],
                        borderColor: [
                            'rgba(41, 128, 185, 1.0)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        enabled: false
                    },
                    legend: {
                        onClick: function (e) {
                            e.stopPropagation();
                        },
                        labels: {
                            boxWidth: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                stepSize: 25,
                                callback: function (value) {
                                    return value + '%';
                                }
                            }
                        }]
                    }
                }
            });
        }


        /***************************************
         * **************RADAR CHART**********
         ***************************************/
        var gruposJaRealizados = {json_encode($grupos)}
        var gruposTodasDisciplinas = {json_encode($gruposCursoInteiro)}
        var gruposSobreposto = {json_encode($grupos)}
        var gruposUsuarioLogado
        {if isset($gruposUsuarioLogado)}
            gruposUsuarioLogado = {json_encode($gruposUsuarioLogado)}
        {else}
            gruposUsuarioLogado = []
        {/if}

        var grupos = []
        var gruposTotal = []
        var gruposLogado = []
        var nomeGrupos = []
        var valorGrupos = []
        var valorGruposTodos = []
        var valorGruposUsuarioLogado = []

        var numeroRadar = 0

        grupos = gruposJaRealizados
        gruposTotal = gruposTodasDisciplinas
        gruposLogado = gruposUsuarioLogado
        for(let grupo in grupos) {
            nomeGrupos.push(grupo)
            valorGrupos.push(grupos[grupo])
            valorGruposTodos.push(gruposTotal[grupo])
            valorGruposUsuarioLogado.push(gruposLogado[grupo])
        }


        var radar = document.getElementById('radar').getContext('2d');

        var opcoes = {
            legend: {
                onClick: function (e) {
                    e.stopPropagation();
                },
                display: false,
                    labels: {
                    boxWidth: 0
                }
            },
            title: {
                display: true,
                    text: "Seu desempenho nas diversas competências do seu curso"
            },
            tooltips: {
                displayColors: false,
                    callbacks: {
                    label: function (tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toFixed(2);
                    }
                }
            },
            scale: {
                ticks: {
                    beginAtZero: true,
                        max: 100,
                        min: 0,
                        stepSize: 20,
                        backdropColor: '#fafafa',
                        callback: function (value, index, values) {
                        if (index === 1) {
                            return "<" + value
                        }
                        return value
                    }
                },
            }
        }

        var radarChart = new Chart(radar, {
            type: 'radar',
            data: {
                labels: nomeGrupos,
                datasets: [
                    {
                        backgroundColor: "rgba(41, 128, 185, 0.5)",
                        borderColor: "rgba(41, 128, 185, 0.8)",
                        lineTension: 0.02,
                        data: valorGrupos,
                    },
                ]
            },
            options: opcoes
        })



        function setRadarRealizadas() {
            radarChart.config.data = {
                labels: nomeGrupos,
                datasets: [
                    {
                        backgroundColor: "rgba(41, 128, 185, 0.5)",
                        borderColor: "rgba(41, 128, 185, 0.8)",
                        lineTension: 0.02,
                        data: valorGrupos
                    }
                ]
            }
            radarChart.update()
        }

        function setRadarTodas() {
            radarChart.config.data = {
                labels: nomeGrupos,
                datasets: [
                    {
                        backgroundColor: "rgba(28,250,61,0.5)",
                        borderColor: "rgba(23,191,54,0.8)",
                        lineTension: 0.02,
                        data: valorGruposTodos
                    }
                ]
            }
            radarChart.update()
        }

        function setRadarSobreposto() {
            radarChart.config.data = {
                labels: nomeGrupos,
                datasets: [
                    {
                        backgroundColor: "rgba(41, 128, 185, 0.5)",
                        borderColor: "rgba(41, 128, 185, 0.8)",
                        lineTension: 0.02,
                        data: valorGrupos
                    },
                    {
                        backgroundColor: "rgba(28,250,61,0.5)",
                        borderColor: "rgba(23,191,54,0.8)",
                        lineTension: 0.02,
                        data: valorGruposTodos
                    }
                ]
            }
            radarChart.update()
        }

        function setRadarSobrepostoAmigo() {
            radarChart.config.data = {
                labels: nomeGrupos,
                datasets: [
                    {
                        backgroundColor: "rgba(41, 128, 185, 0.5)",
                        borderColor: "rgba(41, 128, 185, 0.8)",
                        lineTension: 0.02,
                        data: valorGrupos
                    },
                    {
                        backgroundColor: "rgba(28,250,61,0.5)",
                        borderColor: "rgba(23,191,54,0.8)",
                        lineTension: 0.02,
                        data: valorGruposUsuarioLogado
                    }
                ]
            }
            radarChart.update()

        }
    </script>
{/block}