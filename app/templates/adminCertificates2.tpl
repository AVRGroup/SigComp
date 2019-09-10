{extends 'layout.tpl'}
{block name=content}
    <h1 class="text-center">Gerenciar Certificados</h1>
    <hr>

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
            Certificado alterado com sucesso!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    {foreach $certificates as $certificate}
    <div class="row">
        <div class="col-4">
            <a id="link-img" href="{base_url}/upload/{$certificate->getNome()}" target="_blank">
                {if $certificate->getExtensao() == "pdf"}
                    <embed src="{base_url}/upload/{$certificate->getNome()}" type="application/pdf">
                {else}
                    <img class="card-img-top" src="{base_url}/upload/{$certificate->getNome()}">
                {/if}
            </a>
        </div>

        <div class="col-8">
            <form action="{base_url}/admin/certificate/{$certificate->getId()}/accept" method="post" style="margin-right: 5%">

                <input type="hidden" name="id" value="{$certificate->getId()}">

                <div class="form-row">
                    <div class="col-6">
                        <label for="nome">Nome do Certificado</label>
                        <input id="nome" type="text" class="form-control" name="nome_impresso" value="{$certificate->getNomeImpresso()}">
                    </div>
                    <div class="col-6">
                        <label for="nome_aluno">Aluno</label>
                        <input type="text" class="form-control" disabled value="{$certificate->getUsuario()->getNome()}">
                    </div>
                </div>

                <div class="form-row" style="margin-top: 3%">
                    <div class="col-8">
                        <label for="admin-review-select">Tipo do Certificado</label>
                        <select class="form-control custom-select" id="admin-review-select" name="type">
                            {foreach $certTypes as $value => $name}
                                <option value="{$value}" {if $value == $certificate->getTipo()}selected{/if}>{$name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-4">
                        <label  for="num-horas">Número de horas</label>
                        <input id="num-horas" class="form-control" type="number" name="num_horas" value={$certificate->getNumHoras()} >
                    </div>
                </div>

                <div style="margin-top: 3%" class="form-row">
                    <div class="col-6">
                        <label for="data-inicio">Data de Inicio</label>
                        <input type="date" class="form-control" name="data_inicio" id="data-inicio" value={date_format($certificate->getDataInicio(), "Y-m-d")}>
                    </div>

                    <div class="col-6">
                        <label for="data-fim">Data de Término</label>
                        <input type="date" class="form-control" name="data_fim" id="data-fim" value={date_format($certificate->getDataFim(), "Y-m-d")}>
                    </div>
                </div>

                {if $certificate->getDataInicio1() != null && $certificate->getDataFim1() != null }
                <div style="margin-top: 3%" class="form-row">
                    <div class="col-6">
                        <label for="data-inicio1">Data de Inicio</label>
                        <input type="date" class="form-control" name="data_inicio1" id="data-inicio1" value={$certificate->getDataInicio1()->format("Y-m-d")}>
                    </div>

                    <div class="col-6">
                        <label for="data-fim1">Data de Término</label>
                        <input type="date" class="form-control" name="data_fim1" id="data-fim1" value={$certificate->getDataFim1()->format("Y-m-d")}>
                    </div>
                </div>
                {/if}

                {if $certificate->getDataInicio2() != null && $certificate->getDataFim2() != null}
                    <div style="margin-top: 3%" class="form-row">
                        <div class="col-6">
                            <label for="data-inicio2">Data de Inicio</label>
                            <input type="date" class="form-control" name="data_inicio2" id="data-inicio2" value={$certificate->getDataInicio2()->format("Y-m-d")}>
                        </div>

                        <div class="col-6">
                            <label for="data-fim2">Data de Término</label>
                            <input type="date" class="form-control" name="data_fim2" id="data-fim2" value={$certificate->getDataFim2()->format("Y-m-d")}>
                        </div>
                    </div>
                {/if}


                <div style="margin-top: 4%" class="botoes">
                    <button type="submit" class="btn btn-success">Aceitar</button>
                    <a href="{path_for name="adminRefuseCertificate" data=["id" => $certificate->getId()]}" class="btn btn-danger">Negar</a>
                </div>

            </form>
        </div>

    </div>

    <hr>
    {/foreach}
{/block}
