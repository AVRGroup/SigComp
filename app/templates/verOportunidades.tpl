{extends 'layout.tpl'}
{block name=content}
    <div style="margin: 0 20px">
        <h3 style="margin-bottom: 30px;" class="text-center">Oportunidades</h3>

        {if $loggedUser->getTipo() == 1}
            <div class="text-center">
                <a class="btn btn-lg btn-success" href="{path_for name="cadastrarOportunidade"}" style="color: #fff; margin-bottom: 5%">Cadastrar Oportunidade </a>
            </div>
        {/if}

        <input type="hidden" id="disciplinas-aprovadas" value="{$disciplinasAprovadas}">

        <input type="checkbox" id="filtrar-pre-requisitos" >
        <label for="filtrar-pre-requisitos">Mostrar apenas Oportunidades que tenho os pré-requisitos</label>


        <div class="row">
            {foreach $oportunidades as $indice => $oportunidade}
                <div class="col-6">

                    <input type="hidden" class="oportunidade-{$indice}" value="{$oportunidade->getId()}" >

                    <div class="card-oportunidade card-oportunidade-{$indice} card-oportunidade-{$oportunidade->getId()} card-oportunidade-{$oportunidade->abreviacao()}">

                        <p class="text-center titulo">
                            <span class="borda-titulo-{$oportunidade->abreviacao()}">{$oportunidade->getNomeTipo()}</span>
                        </p>

                        <p class="descricao">{$oportunidade->getDescricao()}</p>

                        <p><span class="weight-600">Professor:</span> {$oportunidade->getProfessor()}</p>

                        <p><span class="weight-600">Vagas:</span> {$oportunidade->getQuantidadeVagas()}</p>

                        <p><span class="weight-600">Data limite para Inscrição:</span> {$oportunidade->getValidade()->format('d/m/Y')}</p>

                        <p>
                            <span class="weight-600">Remuneração:</span>
                            {if $oportunidade->getRemuneracao() == 0}
                                Voluntária
                            {else}
                                R${number_format($oportunidade->getRemuneracao(), 2, '.', '')}
                            {/if}
                        </p>

                        {foreach $oportunidade->getDisciplinas() as $disciplina}
                            {if $disciplina->getNome()}
                                <input type="hidden" class="disciplinas-{$oportunidade->getId()}" value="{$disciplina->getNome()} - {$disciplina->getId()}">
                            {else}
                                <input type="hidden" class="disciplinas-{$oportunidade->getId()}" value="{$disciplina->getCodigo()} - {$disciplina->getId()}">
                            {/if}
                        {/foreach}

                        <button type="button" class="btn btn-{$oportunidade->abreviacao()}" data-toggle="modal" data-target="#maisInformacoes"
                        data-arquivo="{base_url}/upload/{$oportunidade->getArquivo()}" data-tem_arquivo="{isset($oportunidade->getArquivo())}" data-oportunidade="{$oportunidade->getId()}">
                            Mais Informações
                        </button>

                    </div>
                </div>
            {/foreach}
        </div>
    </div>



    <div class="modal fade" id="maisInformacoes" tabindex="-1" role="dialog" aria-labelledby="maisInformacoesLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="maisInformacoesLabel">Pré-Requisitos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="disciplinas"></div>

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
        });

        $("#filtrar-pre-requisitos").change(function () {
            if ($(this).is(':checked')) {
                $(".card-oportunidade").each(function (indice, card) {
                    var idOportunidade = $(".oportunidade-"+indice).val()
                    var requisitos = []

                    $(".disciplinas-"+idOportunidade).each(function (i, disciplina) {
                        var id = parseInt(disciplina.value.substr(disciplina.value.indexOf('-') + 1))
                        requisitos.push(id)
                    })

                    if(!estaContido(requisitos, aprovadas)) {
                        var cardOportunidade = $(".card-oportunidade-"+idOportunidade)
                        cardOportunidade.slideUp()
                    }
                })
            } else {
                $(".card-oportunidade").each(function (indice, card) {
                    $(".card-oportunidade-"+indice).slideDown()
                })
            }
        });

        function estaContido(needle, haystack){
            for(var i = 0; i < needle.length; i++){
                if(haystack.indexOf(needle[i]) === -1)
                    return false;
            }
            return true;
        }

    </script>

{/block}