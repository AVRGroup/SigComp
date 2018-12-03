{extends 'layout.tpl'}
{block name=content}
    <h1 class="text-center">Gerenciar Certificados</h1>
    <hr>
    {foreach $certificates as $certificate}
    <div class="row">

        <div class="col-4">
            <a id="link-img" href="{base_url}/upload/{$certificate->getNome()}" target="_blank">
                <img class="card-img-top img-certificado" src="{base_url}/upload/{$certificate->getNome()}">
            </a>
        </div>

        <div class="col-8">
            <form action="" method="post" style="margin-right: 5%">

                <label for="nome">Nome do Certificado</label>
                <input id="nome" type="text" class="form-control" name="nome_impresso" value={$certificate->getNomeImpresso()}>

                <div class="form-row" style="margin-top: 3%">
                    <div class="col-8">
                        <label for="admin-review-select">Tipo do Certificado</label>
                        <select class="form-control custom-select" id="admin-review-select" onload="teste('kek')" name="type">
                            {foreach $certTypes as $value => $name}
                                <option value="{$value}">{$name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-4">
                        <label  for="num-horas">Número de horas</label>
                        <input id="num-horas" class="form-control" type="number" value={$certificate->getNumHoras()} >
                    </div>
                </div>

                <div style="margin-top: 3%" class="form-row">
                    <div class="col-6">
                        <label for="data-inicio">Data de Inicio</label>
                        <input type="date" class="form-control" name="data_inicio" id="data-inicio" value={date_format($certificate->getDataInicio(), "Y-m-d")}>
                    </div>

                    <div class="col-6">
                        <label for="data-fim">Data de Término</label>
                        <input type="date" class="form-control" name="data_fim" id="data-fim" value={$certificate->getDataFim()->format("Y-m-d")}>
                    </div>
                </div>

                {if $certificate->getDataInicio1() != null && $certificate->getDataFim1() != null }
                <div style="margin-top: 3%" class="form-row">
                    <div class="col-6">
                        <label for="data-inicio">Data de Inicio</label>
                        <input type="date" class="form-control" name="data_inicio" id="data-inicio" value={$certificate->getDataInicio1()->format("Y-m-d")}>
                    </div>

                    <div class="col-6">
                        <label for="data-fim">Data de Término</label>
                        <input type="date" class="form-control" name="data_fim" id="data-fim" value={$certificate->getDataFim1()->format("Y-m-d")}>
                    </div>
                </div>
                {/if}

                {if $certificate->getDataInicio2() != null && $certificate->getDataFim2() != null}
                    <div style="margin-top: 3%" class="form-row">
                        <div class="col-6">
                            <label for="data-inicio">Data de Inicio</label>
                            <input type="date" class="form-control" name="data_inicio" id="data-inicio" value={$certificate->getDataInicio2()->format("Y-m-d")}>
                        </div>

                        <div class="col-6">
                            <label for="data-fim">Data de Término</label>
                            <input type="date" class="form-control" name="data_fim" id="data-fim" value={$certificate->getDataFim2()->format("Y-m-d")}>
                        </div>
                    </div>
                {/if}
                <div style="margin-top: 4%" class="botoes">
                    <a href="{path_for name="adminChangeCertificate" data=["id" => $certificate->getId(), "state" => "true"] queryParams=["isReviewPage" => "true"]}" class="btn btn-success">Aceitar</a>
                    <a href="{path_for name="adminChangeCertificate" data=["id" => $certificate->getId(), "state" => "false"] queryParams=["isReviewPage" => "true"]}" class="btn btn-danger">Negar</a>
                    <button class="btn btn-primary" onclick="teste()">Teste</button>
                </div>
            </form>
        </div>

    </div>

    <hr>
    {/foreach}
{/block}

<script>
</script>