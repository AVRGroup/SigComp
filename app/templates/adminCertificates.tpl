{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Administrar Certificados</h3>
    <h3 class="text-center mt-5 mb-3">Certificados aguardando aprovação</h3>
    <div class="d-flex flex-wrap" id="certificates">
        {foreach $certificates as $certificate}
            <div class="card">
                <a href="{base_url}/upload/{$certificate->getNome()}" target="_blank"><img class="card-img-top" src="{base_url}/upload/{$certificate->getNome()}"></a>
                <div class="card-body d-flex flex-column justify-content-end">
                    <p class="card-text text-center"><span class="badge badge-pill badge-dark">{$certificate->getNomeTipo()}</span><br/>
                        <a href="{path_for name="adminChangeCertificate" data=["id" => $certificate->getId(), "state" => "true"]}" class="badge badge-success">Aceitar</a>
                        <a href="{path_for name="adminChangeCertificate" data=["id" => $certificate->getId(), "state" => "false"]}" class="badge badge-warning">Negar</a>
                        <a href="{path_for name="adminDeleteCertificate" data=["id" => $certificate->getId()]}" class="badge badge-danger">Excluir</a>
                    </p>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">{$certificate->getUsuario()->getNome()}</small>
                </div>
            </div>
        {foreachelse}
            <div class="alert alert-warning w-100 text-center" role="alert">
                Nenhum certificado ainda...
            </div>
        {/foreach}
    </div>
{/block}
