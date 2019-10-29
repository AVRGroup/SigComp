{extends 'layout.tpl'}
{block name=content}
    <div style="margin: 0 20px">
        <h3 style="margin-bottom: 30px;" class="text-center">Oportunidades</h3>

        {if !$loggedUser->isAluno()}
            <div class="text-center">
                <a class="btn btn-lg btn-success" href="{path_for name="cadastrarOportunidade"}" style="color: #fff; margin-bottom: 5%">Cadastrar Oportunidade </a>
            </div>
        {/if}

        <input type="hidden" id="disciplinas-aprovadas" value="{$disciplinasAprovadas}">

        <select id="filtrar-data" class="form-control col-md-10 col-sm-12 mx-sm-auto">
            <option disabled selected>Filtrar</option>
            <option value="todas">Todas oportunidades (padrão)</option>
            <option value="ativas">Todas oportunidades ativas</option>
            <option value="ativas-com-pre-requisitos">Apenas oportunidades ativas que cumpro os pré-requisitos</option>
            <option value="inativas">Apenas oportunidades inativas</option>
        </select>
        <br>

        <input type="hidden" id="periodo-usuario" value="{$periodo}">

        <div class="row">
            {foreach $oportunidades as $indice => $oportunidade}
                <div class="col-sm-12 col-md-6 col-xs-12" style="margin-top: 3%" >

                    <input type="hidden" class="oportunidade-{$indice}" value="{$oportunidade->getId()}" >

                    <div class="card-oportunidade card-oportunidade-{$indice} card-oportunidade-{$oportunidade->getId()} card-oportunidade-{$oportunidade->abreviacao()}">

                        <p class="text-center titulo">
                            <span class="borda-titulo-{$oportunidade->abreviacao()}">{$oportunidade->getNomeTipo()}</span>
                        </p>

                        {if strlen($oportunidade->getDescricao()) > 120}
                            <p class="descricao">{substr($oportunidade->getDescricao(), 0, 120)} ...</p>
                        {else}
                            <p class="descricao">{$oportunidade->getDescricao()}</p>
                        {/if}

                        <p><span class="weight-600">Quem oferece:</span> {$oportunidade->getProfessor()}</p>

                        <p>
                            <span class="weight-600">Vagas:</span>
                            {if $oportunidade->getQuantidadeVagas() == -1}
                                Não Informado
                            {else}
                                {$oportunidade->getQuantidadeVagas()}
                            {/if}
                        </p>

                        <p><span class="weight-600">Data limite para Inscrição:</span> {$oportunidade->getValidade()->format('d/m/Y')}</p>
                        <input type="hidden" class="validade-{$oportunidade->getId()}" value="{$oportunidade->getValidade()->format('d/m/Y')}" >
                        <input type="hidden" class="descricao-{$oportunidade->getId()}" value="{$oportunidade->getDescricao()}" >
                        <input type="hidden" class="vagas-{$oportunidade->getId()}" value="{$oportunidade->getQuantidadeVagas()}" >
                        <input type="hidden" class="professor-{$oportunidade->getId()}" value="{$oportunidade->getProfessor()}" >
                        <input type="hidden" class="remuneracao-{$oportunidade->getId()}" value="{$oportunidade->getRemuneracao()}" >

                        <p>
                            <span class="weight-600">Remuneração:</span>
                            {if $oportunidade->getRemuneracao() == 0}
                                Voluntária
                            {elseif $oportunidade->getRemuneracao() == -1}
                                Não Informada
                            {else}
                                R${number_format($oportunidade->getRemuneracao(), 2, '.', '')}
                            {/if}
                        </p>

                        <input type="hidden" class="periodo-minimo-{$oportunidade->getId()}" value={$oportunidade->getPeriodoMinimo()}>
                        <input type="hidden" class="periodo-maximo-{$oportunidade->getId()}" value={$oportunidade->getPeriodoMaximo()}>

                        {foreach $oportunidade->getDisciplinas() as $disciplina}
                            {if $disciplina->getNome()}
                                <input type="hidden" class="disciplinas-{$oportunidade->getId()}" value="{$disciplina->getNome()} - {$disciplina->getId()}">
                            {else}
                                <input type="hidden" class="disciplinas-{$oportunidade->getId()}" value="{$disciplina->getCodigo()} - {$disciplina->getId()}">
                            {/if}
                        {/foreach}

                        <button type="button" class="btn btn-{$oportunidade->abreviacao()}" data-toggle="modal" data-target="#maisInformacoes"
                            data-arquivo="{base_url}/upload/{$oportunidade->getArquivo()}" data-tem_arquivo="{isset($oportunidade->getArquivo())}" data-oportunidade="{$oportunidade->getId()}"
                            data-periodo_minimo="{$oportunidade->getPeriodoMinimoParaEscrita()}" data-periodo_maximo="{$oportunidade->getPeriodoMaximoParaEscrita()}"
                            data-professor="{$oportunidade->getProfessor()}" data-validade="{$oportunidade->getValidade()->format('d/m/Y')}" data-descricao="{$oportunidade->getDescricao()}"
                            data-remuneracao="{$oportunidade->getRemuneracao()}" data-imagem="{base_url}/upload/{$oportunidade->getArquivoImagem()}"
                        >
                            Mais Informações
                        </button>

                        {if !$usuario->isAluno()}
                            <a style="margin-left: 3%" href="{base_url}/admin/oportunidade/{$oportunidade->getId()}/form-edit"><small><i class="fa fa-edit"></i></small></a>
                            <a style="color: darkred; margin-left: 2%" href="{base_url}/admin/oportunidade/{$oportunidade->getId()}/delete"><small><i class="fa fa-trash"></i></small></a>
                            <a target="_blank" href="{base_url}/oportunidade/{$oportunidade->getId()}" style="float: right;"><small>Link Externo</small></a>
                        {/if}

                    </div>
                </div>
            {/foreach}
        </div>
    </div>

    <div class="modal fade" id="maisInformacoes" tabindex="-1" role="dialog" aria-labelledby="maisInformacoesLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="maisInformacoesLabel">Mais Informações</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p>Pré Requisitos</p>
                    <div class="disciplinas"></div>

                    <hr>

                    <div class="informacoes"></div>

                    <div class="periodos"></div>

                    <a class="download-aquivo" href="">Ver Arquivo</a>
                </div>
            </div>
        </div>
    </div>

{/block}


{block name="javascript"}
    <script>
        var disciplinasAprovadas = {json_encode($disciplinasAprovadas)}

        var aprovadas = []
        for(var index in disciplinasAprovadas) {
            aprovadas.push(parseInt(disciplinasAprovadas[index].disciplina))
        }

        $('#maisInformacoes').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var arquivo = button.data('arquivo')
            var temArquivo = button.data('tem_arquivo')
            var idOportunidade = button.data('oportunidade')
            var periodoMinimo = button.data('periodo_minimo')
            var periodoMaximo = button.data('periodo_maximo')
            var professor = button.data('professor')
            var validade = button.data('validade')
            var remuneracao = button.data('remuneracao')
            var descricao = button.data('descricao')
            var imagem = button.data('imagem')

            $(".periodos").append(
                "<p style='margin-top: 30px'> " +
                    "<span style='font-weight: bold'>Período Mínimo:</span> " + periodoMinimo + " " +
                    "| <span style='font-weight: bold'>Período Maximo:</span> " + periodoMaximo +
                "</p>"
            )

            var htmlImagem = ""

            if(imagem) {
                htmlImagem = "<img style='width:80%; margin: auto' class='text-center mt-3 mb-3' alt='imagem oportunidade' src=' " + imagem + " '>"
            }

            $(".informacoes").append(
                "<div class='row'>" +
                    htmlImagem +
                    "<div style='text-align: justify;' class='col-sm-12'>" + descricao + "</div>" +
                    "<div class='col-sm-6'> <b>Quem oferece: </b>"+ professor +"</div>" +
                    "<div class='col-sm-6'> <b>Remuneração: </b>"+ remuneracao +"</div>" +
                    "<div class='mt-4 col-sm-12 text-center'> <b>Validade: </b>"+ validade +"</div>" +
                "</div>"
            )

            $(".disciplinas-" + idOportunidade).each(function(i, disciplina) {
                var nome = disciplina.value.substr(0, disciplina.value.indexOf('-'))
                var id = parseInt(disciplina.value.substr(disciplina.value.indexOf('-') + 1))

                if(aprovadas.includes(id)) {
                    $(".disciplinas").append(
                        "<span style='border-radius: 20px; background-color: #74eb56; color: #fff; display:inline-block; padding: 10px; margin-left: 10px; margin-top: 10px'>"
                        + nome +
                        "</span>"
                    );

                } else {
                    $(".disciplinas").append(
                        "<span style='border-radius: 20px; background-color: #F96262; color: #fff; display:inline-block; padding: 10px; margin-left: 10px; margin-top: 10px'>"
                        + nome +
                        "</span>"
                    );
                }
            });

            var modal = $(this)
            if(temArquivo) {
                modal.find('.modal-body a').attr("href", arquivo)
                modal.find('.modal-body a').css("display", "block")
            } else {
                modal.find('.modal-body a').css("display", "none")
            }
        })

        $("#maisInformacoes").on("hidden.bs.modal", function () {
            $(".disciplinas").empty()
            $(".periodos").empty()
            $(".informacoes").empty()
        });


        $("#filtrar-data").change(function () {
            var filtro = $(this).val();
            switch (filtro) {
                case "ativas":
                    mostrarOportunidadesAtivas()
                    break;
                case "ativas-com-pre-requisitos":
                    mostrarOportunidadesAtivasComPreRequisitos()
                    break;
                case "inativas":
                    mostrarOportunidadesInativas()
                    break;
                default:
                    mostrarTodasOportunidades()
                    break;
            }
        })

        function mostrarOportunidadesAtivas() {
            $(".card-oportunidade").each(function (indice, card) {
                var idOportunidade = $(".oportunidade-"+indice).val()
                var cardOportunidade = $(".card-oportunidade-"+idOportunidade)

                if(estaAtiva(idOportunidade)) {
                    cardOportunidade.slideDown()
                }
                else {
                    cardOportunidade.slideUp()
                }

            })
        }


        function mostrarOportunidadesInativas() {
            $(".card-oportunidade").each(function (indice, card) {
                var idOportunidade = $(".oportunidade-"+indice).val()
                var cardOportunidade = $(".card-oportunidade-"+idOportunidade)

                if(estaAtiva(idOportunidade)) {
                    cardOportunidade.slideUp()
                }
                else {
                    cardOportunidade.slideDown()
                }
            })
        }


        function mostrarOportunidadesAtivasComPreRequisitos() {
            $(".card-oportunidade").each(function (indice, card) {
                var idOportunidade = $(".oportunidade-"+indice).val()
                var cardOportunidade = $(".card-oportunidade-"+idOportunidade)

                if(tenhoPreRequisito(idOportunidade) && estaAtiva(idOportunidade)) {
                    cardOportunidade.slideDown()
                }
                else {
                    cardOportunidade.slideUp()
                }

            })
        }

        function estaAtiva(idOportunidade) {
            var validade = $(".validade-"+idOportunidade).val()
            var hoje = dataHoje()

            validade = criarObjetoDate(validade)
            hoje = criarObjetoDate(hoje)

            return validade >= hoje
        }

        function tenhoPreRequisito(idOportunidade) {
            var periodoUsuario = $("#periodo-usuario").val()
            var periodoMinimo = $(".periodo-minimo-"+idOportunidade).val()
            var periodoMaximo = $(".periodo-maximo-"+idOportunidade).val()

            var requisitos = []

            $(".disciplinas-"+idOportunidade).each(function (i, disciplina) {
                var id = parseInt(disciplina.value.substr(disciplina.value.indexOf('-') + 1))
                requisitos.push(id)
            })

            return estaContido(requisitos, aprovadas) && estaDentroDoPeriodo(periodoUsuario, periodoMinimo, periodoMaximo);
        }

        function estaContido(needle, haystack){
            for(var i = 0; i < needle.length; i++){
                if(haystack.indexOf(needle[i]) === -1)
                    return false;
            }

            return true;
        }

        function estaDentroDoPeriodo(periodoUsuario, periodoMinimo, periodoMaximo) {
           return periodoMaximo >= periodoUsuario && periodoMinimo <= periodoUsuario;
        }


        function mostrarTodasOportunidades() {
            $(".card-oportunidade").each(function (indice, card) {
                var idOportunidade = $(".oportunidade-" + indice).val()
                var cardOportunidade = $(".card-oportunidade-" + idOportunidade)

                cardOportunidade.slideDown()
            })
        }

        function dataHoje() {
            var hoje = new Date()
            var dd = String(hoje.getDate()).padStart(2, '0');
            var mm = String(hoje.getMonth() + 1).padStart(2, '0');
            var yyyy = hoje.getFullYear();

            hoje = dd + '/' + mm + '/' + yyyy;
            return hoje
        }

        function criarObjetoDate(string) {
            var data = string.split('/')
            return new Date(data[2], data[1] - 1, data[0] );
        }

    </script>

{/block}