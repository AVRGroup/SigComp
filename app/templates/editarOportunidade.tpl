{extends 'layout.tpl'}

{block name=content}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <div class="nova-oportunidade">
        <h4 align="center">Editar Oportunidade</h4>

        {if isset($error)}
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {$error}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        {/if}

        {if isset($success)}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Oportunidade cadastrada com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        {/if}

        <form method="POST" action="{base_url}/admin/oportunidade/{$oportunidade->getId()}/edit" enctype="multipart/form-data">

            <div class="form-row">
                <div class="custom-file">
                    <label class="custom-file-label" for="pdf-oportunidade">PDF da oportunidade:</label>
                    <input  type="file" class="custom-file-input" id="pdf-oportunidade" name="pdf_oportunidade" value="{$oportunidade->getArquivo()}">
                </div>
            </div>

            <div class="form-row">
                <div class="col-6">
                    <label for="tipo_oportunidade">Escolha o tipo:</label>
                    <select class="form-control" name="tipo_oportunidade">
                        <option value="0" {if $oportunidade->getTipo() == 0} selected {/if}>Iniciação Científica</option>
                        <option value="1" {if $oportunidade->getTipo() == 1} selected {/if}>Treinamento Profissional</option>
                        <option value="2" {if $oportunidade->getTipo() == 2} selected {/if}>Estágio</option>
                    </select>
                </div>

                <div style="margin-left: 10%;" class="col-3">
                    <label for="numero-vagas">Quantidade de vagas:</label>
                    <input id="numero-vagas" type="number" class="form-control" name="numero_vagas"
                        {if $oportunidade->getQuantidadeVagas() > -1 }
                            value="{$oportunidade->getQuantidadeVagas()}"
                        {else}
                            disabled="disabled"
                        {/if}>

                    <input id="vagas-informadas" type="radio" value="9999" name="informar-vagas" checked>
                    <label for="vagas-informadas">Informar</label>

                    <input id="vagas-nao-informadas" type="radio" value="-1" name="informar-vagas"
                            {if $oportunidade->getQuantidadeVagas() == -1} checked {/if}>
                    <label for="vagas-nao-informadas">Não Informado</label>

                </div>
            </div>

            <div class="form-row">
                <label for="nome_professor">Nome da pessoa/instituição que está oferecendo:</label>
                <input class="form-control" type="text" name="nome_professor" value="{$oportunidade->getProfessor()}">
            </div>

            <label style="margin-top: 5%" for="remuneracao">Remuneração:</label for="remuneracao">
            <div class="form-row" style="margin-top: 0">
                <div class="form-check form-check-inline">
                    <input id="voluntario" class="form-check-input" name="tem_remuneracao" value="voluntario" type="radio"
                            {if $oportunidade->getRemuneracao() == 0} checked {/if}
                    >
                    <label for="voluntario" class="form-check-label">Voluntário</label>
                </div>

                <div class="form-check form-check-inline">
                    <input id="nao-informado" class="form-check-input" name="tem_remuneracao" value="nao_informado" type="radio"
                            {if $oportunidade->getRemuneracao() == -1} checked {/if}
                    >
                    <label for="voluntario" class="form-check-label">Não Informado</label>
                </div>

                <div class="form-check form-check-inline">
                    <input id="remunerado" class="form-check-input escolher-valor" name="tem_remuneracao" value="remunerado" type="radio"
                            {if $oportunidade->getRemuneracao() > 0} checked {/if}
                    >
                    <label for="remunerado" class="form-check-label" >Escolher Valor:</label>
                </div>

                <input id="valor-remuneracao" type="number" class="form-control col-4" name="valor_remuneracao"
                        {if $oportunidade->getRemuneracao() <= 0} disabled="disabled" {/if}
                        {if $oportunidade->getRemuneracao() > 0} value="{$oportunidade->getRemuneracao()}" {/if}
                >
            </div>


            <div class="form-row">
                <div class="col-4">
                    <label for="validade">Data Limite para Inscrição:</label>
                    <input type="date" name="validade" class="form-control" value="{$oportunidade->getValidade()->format('Y-m-d')}">
                </div>
            </div>

            <div class="form-row">
                <div class="col-6">
                    <label for="periodo-minimo">Período Mínimo</label>
                    <select class="form-control" name="periodo_minimo" id="periodo-minimo">
                        <option value="-1">Sem limite</option>
                        {for $i=1; $i<= 9; $i++}
                            <option value="{$i}" {if $oportunidade->getPeriodoMinimo() == $i} selected {/if}>{$i}º período</option>
                        {/for}
                    </select>
                </div>

                <div class="col-6">
                    <label for="periodo-maximo">Período Máximo</label>
                    <select class="form-control" name="periodo_maximo" id="periodo-maximo">
                        <option value="999">Sem limite</option>
                        {for $i=1; $i<= 9; $i++}
                            <option value="{$i}" {if $oportunidade->getPeriodoMaximo() == $i} selected {/if}>{$i}º período</option>
                        {/for}
                    </select>
                </div>
            </div>

            <div class="form-row">
                <label for="requisitos">Pré-Requisitos:</label>
                <select name="pre_requisitos[]" multiple="multiple" class="form-control pre-requisitos">
                    {foreach $disciplinas as $disciplina}
                        <option data-codigo="{$disciplina->getCodigo()}" value="{$disciplina->getId()}">
                            {$disciplina->getCodigo()}

                            {if isset($disciplina->getNome())}
                                - {$disciplina->getNome()}
                            {/if}
                        </option>
                    {/foreach}
                </select>
            </div>

            <div class="form-row">
                <div class="custom-file">
                    <label class="custom-file-label" for="imagem-oportunidade">Imagem da Oportunidade:</label>
                    <input  type="file" class="custom-file-input" id="imagem-oportunidade" name="imagem_oportunidade" value="{$oportunidade->getArquivoImagem()}">
                </div>
            </div>

            <div class="form-row">
                <label for="descricao">Descrição da Oportunidade</label>
            </div>
            <div id="editor"></div>

            <input type="hidden" id="descricao-oportunidade" name="descricao" value="{$oportunidade->getDescricao()}">


            <button type="submit" class="btn btn-primary" onclick="addContentToInput()" style="margin-top: 5%;">Editar Oportunidade</button>
        </form>
    </div>

{/block}

{block name="javascript"}
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ]
            }
        });

        var descricao = document.getElementById("descricao-oportunidade").value
        if(descricao !== "<p><br></p>") {
            document.querySelector('#editor').children[0].innerHTML = descricao
        }

        function addContentToInput() {
            var html = document.querySelector('#editor').children[0].innerHTML;
            document.getElementById("descricao-oportunidade").value = html;
        }

        $(document).ready(function() {
            function formatDisciplina (disciplina) {
                if (!disciplina.id) {
                    return disciplina.text;
                }

                var $disciplina = $('<span><span></span></span>');

                var nomeDisciplina = (disciplina.text);
                var codigoDisciplina = nomeDisciplina.substr(0, nomeDisciplina.indexOf('-'))

                if (codigoDisciplina !== "") {
                    $disciplina.find("span").text(codigoDisciplina);
                } else {
                    $disciplina.find("span").text(nomeDisciplina);
                }

                return $disciplina;
            }


            $('.pre-requisitos').select2({
                placeholder: "Selecione as disciplinas",
                allowClear: true,
                templateSelection: formatDisciplina
            });
        });



        $('#remunerado').click(function() {
            $("#valor-remuneracao").prop("disabled",false);
        });

        $('#voluntario').click(function() {
            $("#valor-remuneracao").prop("disabled",true);
        });

        $('#vagas-nao-informadas').click(function() {
            $("#numero-vagas").prop("disabled",true);
        });

        $('#vagas-informadas').click(function() {
            $("#numero-vagas").prop("disabled",false);
        });

    </script>

{/block}