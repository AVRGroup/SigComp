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

        <div class="col-6">
            <form action="" style="margin-right: 5%">
                <select class="form-control custom-select" id="admin-review-select" onload="teste('kek')" name="type">
                    {foreach $certTypes as $value => $name}
                        <option value="{$value}">{$name}</option>
                    {/foreach}
                </select>

                <label  style="margin-top: 4%" for="num-horas">Número de horas</label>
                <input id="num-horas" class="form-control" type="number" value={$certificate->getNumHoras()} >

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