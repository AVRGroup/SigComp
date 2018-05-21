{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Certificados</h3>
    <h4 class="mt-3">Enviar Certificado</h4>
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
            Certificado enviado com sucesso!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}
    <p>O arquivo deve estar no formato .jpg, .png ou .pdf. Tamanho máximo aceito: 2Mb.</p>
    <form method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="certificate" name="certificate">
                <label class="custom-file-label" for="certificate">Selecionar certificado</label>
            </div>
            <select class="custom-select" id="type" name="type">
                <option value="-1" selected>Selecione o tipo de certificado</option>
                {foreach $certTypes as $value => $name}
                    <option value="{$value}">{$name}</option>
                {/foreach}
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Enviar</button>
            </div>
        </div>
    </form>
    <h3 class="text-center mt-5 mb-3">Seus certificados</h3>
    <div class="d-flex flex-wrap" id="certificates">
        {foreach $certificates as $certificate}
            <div class="card">
                <a href="{base_url}/upload/{$certificate->getNome()}" target="_blank"><img class="card-img-top" src="{base_url}/upload/{$certificate->getNome()}"></a>
                <div class="card-body d-flex flex-column justify-content-end">
                    <p class="card-text text-center"><span class="badge badge-pill badge-dark">{$certificate->getNomeTipo()}</span><br/>
                        {if $certificate->getValido()}
                            <span class="badge badge-success">Validado</span>
                        {else}
                            {if $certificate->isInReview()}
                                <span class="badge badge-info">Aguardando aprovação</span>
                            {else}
                                <span class="badge badge-warning">Invalidado</span>
                            {/if}
                            <a href="{path_for name="deleteCertificate" data=["id" => $certificate->getId()]}" class="badge badge-danger">Excluir</a>
                        {/if}
                    </p>
                </div>
            </div>
        {foreachelse}
            <div class="alert alert-warning w-100 text-center" role="alert">
                Nenhum certificado ainda...
            </div>
        {/foreach}
    </div>
{/block}
