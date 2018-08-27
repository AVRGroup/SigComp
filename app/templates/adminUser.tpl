{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Gerenciar Usuário</h3>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="text-center">
                    <img src="{base_url}/{if $user->getFoto()}upload/{$user->getFoto()}{else}img/silhueta.jpg{/if}" class="img-thumbnail" alt="{$user->getNome()}" width="190" height="190">
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
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getInteligencia())/17 }%;">{((100 * $user->getInteligencia())/17)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Sabedoria:</b> {$user->getSabedoria()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getSabedoria())/16}%;">{((100 * $user->getSabedoria())/16)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Destreza:</b> {$user->getDestreza()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getDestreza())/14}%;">{((100 * $user->getDestreza())/14)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Força:</b> {$user->getForca()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getForca())/11}%;">{((100 * $user->getForca())/11)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Carisma:</b> {$user->getCarisma()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getCarisma())/2}%;">{((100 * $user->getCarisma())/2)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Cultura:</b> {$user->getCultura()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $user->getCultura())/($user->getCultura() +50 ) }%;">{((100 * $user->getCultura())/($user->getCultura() + 50 ))|string_format:"%.2f"}%</div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <p></p>
                <h4 class="text-center">Quadro de medalhas</h4>
                <ul class="nav nav-tabs" id="badgesTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" id="current-tab" role="tab" href="#current">Medalhas Conquistadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="possible-tab" role="tab" href="#possible">Medalhas Possíveis</a>
                    </li>
                </ul>
                <div class="tab-content" id="badgesTabContent">
                    <div class="tab-pane fade show active" id="current" role="tabpanel" aria-labelledby="current-tab">
                        <table>
                            <tbody>
                            {$qtde = 0}
                            <tr>
                                {foreach $medalhas as $medalha}
                                {if $qtde < 10}
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/{$medalha['imagem']} " class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>{$medalha['nome']}</small></p>
                                        </div>
                                    </div>
                                </td>
                                {$qtde = $qtde + 1}
                                {else}
                            </tr>{$qtde = 0}<tr>
                                {/if}
                                {/foreach}
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="possible" role="tabpanel" aria-labelledby="possible-tab">
                        <table>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/badge.png" class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>NOME DA MEDALHA</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/badge.png" class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>NOME DA MEDALHA</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/badge.png" class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>NOME DA MEDALHA</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/badge.png" class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>NOME DA MEDALHA</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/badge.png" class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>NOME DA MEDALHA</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/badge.png" class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>NOME DA MEDALHA</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/badge.png" class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>NOME DA MEDALHA</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/badge.png" class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>NOME DA MEDALHA</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="img-thumbnail">
                                        <img src="{base_url}/img/badge.png" class="img-fluid">
                                        <div class="caption">
                                            <p class="text-center"><small>NOME DA MEDALHA</small></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="text-center mt-3">Notas dos usuários</h4>
    <ul>
        {foreach $user->getNotas() as $nota}
            <li>{$nota->getDisciplina()->getCodigo()}({$nota->getEstado()}) -> {$nota->getValor()} </li>
        {/foreach}
    </ul>
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
