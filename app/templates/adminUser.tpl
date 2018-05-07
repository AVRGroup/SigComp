{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Gerenciar Usuário</h3>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="text-center">
                    <img src="{base_url}/img/silhueta.jpg" class="img-thumbnail" alt="{$loggedUser->getNome()}" width="190" height="190">
                    {$user->getNome()}
                </div>
            </div>
            <div class="col-9">
                <h4 class="text-center">Estatíticas</h4>
                <p class="mb-0 mt-3"><b>Experiência:</b> {$user->getExperiencia()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getExperiencia())/($user->getExperiencia() +500 ) }%;">{((100 * $user->getExperiencia())/($user->getExperiencia() +500 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Inteligência:</b> {$user->getInteligencia()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getInteligencia())/($user->getInteligencia() +200 ) }%;">{((100 * $user->getInteligencia())/($user->getInteligencia() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Sabedoria:</b> {$user->getSabedoria()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getSabedoria())/($user->getSabedoria() +200 ) }%;">{((100 * $user->getSabedoria())/($user->getSabedoria() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Destreza:</b> {$user->getDestreza()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getDestreza())/($user->getDestreza() +200 ) }%;">{((100 * $user->getDestreza())/($user->getDestreza() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Força:</b> {$user->getForca()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getForca())/($user->getForca() +200 ) }%;">{((100 * $user->getForca())/($user->getForca() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Carisma:</b> {$user->getCarisma()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getCarisma())/($user->getCarisma() +200 ) }%;">{((100 * $user->getCarisma())/($user->getCarisma() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Cultura:</b> {$user->getCultura()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getCultura())/($user->getCultura() +50 ) }%;">{((100 * $user->getCultura())/($user->getCultura() + 50 ))|string_format:"%.2f"}%</div>
                </div>

                <h4 class="text-center mt-3">Notas dos usuários</h4>
                <ul>
                    {foreach $user->getNotas() as $nota}
                        <li>{$nota->getDisciplina()->getCodigo()}({$nota->getEstado()}) -> {$nota->getValor()} </li>
                    {/foreach}
                </ul>
            </div>

        </div>
    </div>
    <h3 class="text-center mt-5 mb-3">Certificados</h3>
    <div class="d-flex flex-wrap" id="certificates">
        {foreach $user->getCertificados() as $certificate}
            <div class="card">
                <a href="{base_url}/upload/{$certificate->getNome()}" target="_blank"><img class="card-img-top" src="{base_url}/upload/{$certificate->getNome()}"></a>
                <div class="card-body d-flex flex-column justify-content-end">
                    <p class="card-text text-center"><span class="badge badge-pill badge-dark">{$certificate->getNomeTipo()}</span><br/>
                        {if $certificate->getValido()}
                            <span class="badge badge-success">Validado</span>
                        {elseif $certificate->isInReview()}
                            <span class="badge badge-info">Aguardando aprovação</span>
                        {else}
                            <span class="badge badge-warning">Invalidado</span>
                        {/if}
                        <br/><a href="{path_for name="adminChangeCertificate" data=["id" => $certificate->getId(), "state" => "true"]}" class="badge badge-success">Aceitar</a>
                        <a href="{path_for name="adminChangeCertificate" data=["id" => $certificate->getId(), "state" => "false"]}" class="badge badge-warning">Negar</a>
                        <a href="{path_for name="adminDeleteCertificate" data=["id" => $certificate->getId()]}" class="badge badge-danger">Excluir</a>
                    </p>
                </div>
            </div>
            {foreachelse}
            <div class="alert alert-warning w-100 text-center" role="alert">
                Nenhum certificado encontrado!
            </div>
        {/foreach}
    </div>
{/block}
