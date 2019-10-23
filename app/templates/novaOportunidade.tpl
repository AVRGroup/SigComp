{extends 'layout.tpl'}

{block name=content}
    <div class="nova-oportunidade">
        <h4 align="center">Cadastrar Oportunidade</h4>

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

        <form method="POST" action="{base_url}/admin/criar-oportunidade" enctype="multipart/form-data">

            <div class="form-row">
                <div class="custom-file">
                    <label class="custom-file-label" for="pdf-oportunidade">PDF da oportunidade:</label>
                    <input  type="file" class="custom-file-input" id="pdf-oportunidade" name="pdf_oportunidade">
                </div>
            </div>

            <div class="form-row">
                <div class="col-6">
                    <label for="tipo_oportunidade">Escolha o tipo:</label>
                    <select class="form-control" name="tipo_oportunidade">
                        <option value="0">Iniciação Científica</option>
                        <option value="1">Treinamento Profissional</option>
                        <option value="2">Estágio</option>
                    </select>
                </div>

                <div style="margin-left: 10%;" class="col-3">
                    <label for="numero-vagas">Quantidade de vagas:</label>
                    <input id="numero-vagas" type="number" class="form-control" name="numero_vagas">

                    <input id="vagas-informadas" type="radio" value="9999" name="informar-vagas" checked> <label for="vagas-informadas">Informar</label>
                    <input id="vagas-nao-informadas" type="radio" value="-1" name="informar-vagas"> <label for="vagas-nao-informadas">Não Informado</label>
                </div>
            </div>

            <div class="form-row">
                <label for="nome_professor">Nome da pessoa/instituição que está oferecendo:</label>
                <input class="form-control" type="text" name="nome_professor">
            </div>

            <label style="margin-top: 5%" for="remuneracao">Remuneração:</label for="remuneracao">
            <div class="form-row" style="margin-top: 0">
                <div class="form-check form-check-inline">
                    <input id="voluntario" class="form-check-input" name="tem_remuneracao" value="voluntario" type="radio" checked>
                    <label for="voluntario" class="form-check-label">Voluntário</label>
                </div>

                <div class="form-check form-check-inline">
                    <input id="nao-informado" class="form-check-input" name="tem_remuneracao" value="nao_informado" type="radio">
                    <label for="nao-informado" class="form-check-label">Não Informado</label>
                </div>

                <div class="form-check form-check-inline">
                    <input id="remunerado" class="form-check-input escolher-valor" name="tem_remuneracao" value="remunerado" type="radio">
                    <label for="remunerado" class="form-check-label">Escolher Valor:</label>
                </div>

                <input id="valor-remuneracao" type="number" class="form-control col-4" name="valor_remuneracao" disabled="disabled">
            </div>


            <div class="form-row">
                <div class="col-4">
                    <label for="validade">Data Limite para Inscrição:</label>
                    <input type="date" name="validade" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="col-6">
                    <label for="periodo-minimo">Período Mínimo</label>
                    <select class="form-control" name="periodo_minimo" id="periodo-minimo">
                        <option value="-1">Sem limite</option>
                        {for $i=1; $i<= 9; $i++}
                            <option value="{$i}">{$i}º período</option>
                        {/for}
                    </select>
                </div>

                <div class="col-6">
                    <label for="periodo-maximo">Período Máximo</label>
                    <select class="form-control" name="periodo_maximo" id="periodo-maximo">
                        <option value="999">Sem limite</option>
                        {for $i=1; $i<= 9; $i++}
                            <option value="{$i}">{$i}º período</option>
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
                <label for="descricao">Descrição da Oportunidade</label>
                <textarea class="form-control" name="descricao"  cols="30" rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 5%;">Cadastrar Oportunidade</button>
        </form>
    </div>

{/block}

{block name="javascript"}
    <script>
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