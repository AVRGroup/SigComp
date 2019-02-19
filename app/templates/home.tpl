{extends 'layout.tpl'}
{block name=content}
    <div class="container">
        <div class="row" onLoad="window.scroll(0, 100)">
            <div class="col-3">
                <div class="text-center">

                    <div class="changePic">
                        <div class="changePicButton text-center" data-toggle="modal" data-target="#chagePhotoModal">
                            <i class="fas fa-camera" style="font-size: 30px;"></i>
                            <p>Alterar Foto</p>
                        </div>
                        <img src="{base_url}/{if $usuario->getFoto()}upload/{$usuario->getFoto()}{else}img/silhueta.jpg{/if}"
                             class="img-thumbnail" alt="{$usuario->getNome()}" width="190" height="190">
                    </div>

                    <div class="align-content-lg-center">

                        {if $usuario->getFacebook() == null}
                            <img src="{base_url}/img/fb_preto.png" class="img-thumbnail" alt="Facebook" width="42" height="42">
                        {else}
                            <a href="{$usuario->getFacebook()}" target="_blank"><img src="{base_url}/img/fb.png" class="img-thumbnail" alt="Facebook" width="42" height="42"></a>
                        {/if}

                        {if $usuario->getInstagram() == null}
                            <img src="{base_url}/img/instagram_preto.jpg" class="img-thumbnail" alt="Instagram" width="42" height="42">
                        {else}
                            <a href="{$usuario->getInstagram()}" target="_blank"><img src="{base_url}/img/instagram.jpg" class="img-thumbnail" alt="Instagram" width="42" height="42"></a>
                        {/if}

                        {if $usuario->getLinkedin() == null}
                            <img src="{base_url}/img/linkedin_preto.png" class="img-thumbnail" alt="LinkedIn" width="42" height="42">
                        {else}
                            <a href="{$usuario->getLinkedin()}" target="_blank"><img src="{base_url}/img/linkedin.png" class="img-thumbnail" alt="LinkedIn" width="42" height="42"></a>
                        {/if}

                        {if $usuario->getLattes() == null}
                            <img src="{base_url}/img/lattes_preto.png" class="img-thumbnail" alt="Lattes" width="42" height="42">
                        {else}
                            <a href="{$usuario->getLattes()}" target="_blank"><img src="{base_url}/img/lattes.png" class="img-thumbnail" alt="Lattes" width="42" height="42"></a>
                        {/if}

                    </div>

                    <div class="sobre-mim">
                        <h5>Sobre mim</h5>
                        <textarea name="sobre_mim" id="sobre-mim" cols="25" disabled rows="6" maxlength="10" >{$usuario->getSobreMim()}</textarea>
                    </div>

                    <div><h6>Grade: {$usuario->getGrade()}</h6></div>

                </div>
            </div>
            <div class="col-9">
                <h4 class="text-center">{if $usuario->getNomeReal()}{$usuario->getNome()}{else}Usuario {$usuario->getId()}{/if}</h4>

                <p class="mb-0 mt-3 nome-atributos"><b>Experiência:</b> {$usuario->getExperiencia()}</p>
                <button type="button" class="btn btn-danger btn-circle info-atributos" data-toggle="popover"  data-placement="right"  data-trigger="focus" title="XP"
                          data-content="Indica a sua vivência no curso! Cada aprovação concede +100xp e cada certificado de evento, palestra ou afins concede +10xp">
                    ?
                </button>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getExperiencia())/($usuario->getExperiencia() +500 ) }%;">{((100 * $usuario->getExperiencia())/($usuario->getExperiencia() +500 ))|string_format:"%.2f"}%</div>
                </div>


                <p class="mb-0 mt-3 nome-atributos"><b>Força:</b> {$usuario->getForca()}</p>
                <button type="button" class="btn btn-danger btn-circle info-atributos" data-toggle="popover"  data-placement="right"  data-trigger="focus" title="FOR"
                        data-content="Aplicação das teorias matemáticas. Suas notas em matérias como
                                        Equações Diferenciais, GA e os Cálculos aumentam sua força">
                    ?
                </button>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getForca())/110}%;">{((100 * $usuario->getForca())/110)|string_format:"%.2f"}%</div>
                </div>


                <p class="mb-0 mt-3 nome-atributos"><b>Destreza:</b> {$usuario->getDestreza()}</p>
                <button type="button" class="btn btn-danger btn-circle info-atributos" data-toggle="popover"  data-placement="right"  data-trigger="focus" title="DEX"
                        data-content="Mão na massa: programar! Suas notas em matérias como os Labs de Programação e Grafos aumentam sua destreza">
                    ?
                </button>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getDestreza())/140}%;">{((100 * $usuario->getDestreza())/140)|string_format:"%.2f"}%</div>
                </div>



                <p class="mb-0 mt-3 nome-atributos"><b>Inteligência:</b> {$usuario->getInteligencia()}</p>
                <button type="button" class="btn btn-danger btn-circle info-atributos" data-toggle="popover"  data-placement="right"  data-trigger="focus" title="INT"
                        data-content="Aprender novas linguagens e suas lógicas. Suas notas em matérias como Algoritmos, Estrutura de dados e Circuitos digitais
                                        aumentam sua inteligência">
                    ?
                </button>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {((100*$usuario->getInteligencia())/170)}%;">{((100 * $usuario->getInteligencia())/170)|string_format:"%.2f"}%</div>
                </div>


                <p class="mb-0 mt-3 nome-atributos"><b>Sabedoria:</b> {$usuario->getSabedoria()}</p>
                <button type="button" class="btn btn-danger btn-circle info-atributos" data-toggle="popover"  data-placement="right"  data-trigger="focus" title="SAB"
                        data-content="Aplicação da computação em problemas. Suas notas em matérias como Banco de Dados, Modelagem de Sistemas e Pesquisa Operacional aumentam sua sabedoria">
                    ?
                </button>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getSabedoria())/160}%;">{((100 * $usuario->getSabedoria())/160)|string_format:"%.2f"}%</div>
                </div>




                <p class="mb-0 mt-3 nome-atributos"><b>Cultura:</b> {$usuario->getCultura()}</p>
                <button type="button" class="btn btn-danger btn-circle info-atributos" data-toggle="popover"  data-placement="right"  data-trigger="focus" title="CULT"
                        data-content="Participação em eventos. Cada certificado seu que foi aprovado condece +10 de cultura">
                    ?
                </button>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getCultura())/($usuario->getCultura() +50 ) }%;">{((100 * $usuario->getCultura())/($usuario->getCultura() + 50 ))|string_format:"%.2f"}%</div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                    <p></p>
                <div class="row">
                    <h4 class="text-center col-11">Quadro de medalhas</h4>
                    <div class="col-1">
                        <button type="button" class="btn btn-success btn-circle" data-toggle="popover"  data-placement="top"  data-trigger="focus"
                                title="Informações"
                                data-content="As medalhas são uma forma de você guardar suas realizações durante o curso! Algumas são atribuídas ao final
                                de cada semestre (como as de IRA) e outras ao registrar seus certificados no sistema (como as de Monitoria, GET...)">
                            ?
                        </button>
                    </div>

                </div>
                <ul class="nav nav-tabs" id="badgesTab" role="tablist">
                    {if $usuario->getTipo()!=1}
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" id="current-tab" role="tab" href="#current">Medalhas Conquistadas</a>
                    </li>
                    {/if}
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="possible-tab" role="tab" href="#possible">Medalhas Possíveis</a>
                    </li>
                </ul>
                <div class="tab-content" id="badgesTabContent">

                    {if $usuario->getTipo()!=1 && $usuario->getTipo()!=2}
                    <div class="tab-pane fade show active" id="current" role="tabpanel" aria-labelledby="current-tab">
                        <table>
                            <tbody>
                            {$novaLinha = 1}
                            {$numMedalhas = 0}
                            {$i=0}
                            {$auxI = 0}

                            {foreach $medalhas as $medal}
                                {$numMedalhas = $numMedalhas + 1}
                            {/foreach}

                            {while $novaLinha === 1}
                                <tr>
                                    {$novaLinha = 0}
                                    {while $i < $numMedalhas}
                                        <td>
                                            <div class="img-thumbnail altura-medalha" style="max-width: 100px;">
                                                <img src="{base_url}/img/{$medalhas[$i].imagem}" class="img-fluid">
                                                <div class="caption">
                                                    <p class="text-center"><small class="legenda-imagem">{$medalhas[$i].nome}</small></p>
                                                </div>
                                            </div>
                                        {$i = $i + 1}
                                        {$auxI = $auxI + 1}
                                        </td>
                                        {if $auxI > 8}
                                            {$novaLinha = 1}
                                            {$auxI = 0}
                                            {break}
                                        {/if}
                                    {/while}
                                </tr>
                            {/while}
                            </tbody>
                        </table>
                    </div>
                    {/if}
                    <div class="tab-pane fade" id="possible" role="tabpanel" aria-labelledby="possible-tab">
                        <table>
                            <tbody>
                            {$novaLinha = 1}
                            {$numMedalhas = 0}
                            {$i=0}
                            {$auxI = 0}

                            {foreach $todasMedalhas as $medal}
                                {$numMedalhas = $numMedalhas + 1}
                            {/foreach}

                            {while $novaLinha === 1}
                                <tr>
                                {$novaLinha = 0}
                                {while $i < $numMedalhas}
                                    <td>
                                        <div class="img-thumbnail altura-medalha" style="max-width: 90px;">
                                            <img src="{base_url}/img/{$todasMedalhas[$i].imagem}" class="img-fluid">
                                            <div class="caption">
                                                <p class="text-center"><small class="legenda-imagem">{$todasMedalhas[$i].nome}</small></p>
                                            </div>
                                        </div>
                                    {$i = $i + 1}
                                    {$auxI = $auxI + 1}
                                    </td>
                                    {if $auxI > 8}
                                        {$novaLinha = 1}
                                        {$auxI = 0}
                                        {break}
                                    {/if}
                                {/while}
                                </tr>
                            {/while}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6" style="margin-top: 1.8%">
                <div class="row">
                    <h4 class="text-center col-10">Melhor IRA Geral</h4>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger btn-circle" data-toggle="popover"  data-placement="top"  data-trigger="focus"
                                title="Informações"
                                data-content="Esse é o IRA geral, considerando todos os seus períodos. São considerados apenas os alunos ativos no curso">
                            ?
                        </button>
                    </div>
                </div>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">IRA</th>
                    </tr>
                    </thead>
                    <tbody>
                    {$i = 1}
                    {foreach $top10Ira as $user}
                        <tr>
                            <th scope="row">{$i++}</th>
                            <td>{if $user->getNomeReal()}{$user->getNomeAbreviado()} {else}USUARIO {$user->getId()}{/if}</td>
                            <td>{$user->getIra()|string_format:"%.2f"}</td>
                        </tr>
                    {/foreach}
                </table>
            </div>
            <div class="col-6" style="margin-top: 1.8%">
                <div class="row">
                    <div class="col-10">
                        <h4 class="text-center">Melhor IRA No Período</h4>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger btn-circle" data-toggle="popover"  data-placement="top"  data-trigger="focus"
                                title="Informações"
                                data-content="Esse é o IRA somando as notas apenas do ultimo periodo. São considerados aqueles que fizeram
                                              pelo menos 4 matérias dos departamentos DCC, MAT, FIS ou EST">
                            ?
                        </button>
                    </div>
                </div>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">IRA</th>
                    </tr>
                    </thead>
                    <tbody>
                    {$i = 1}
                    {foreach $top10IraPeriodoPassado as $user}
                        <tr>
                            <th scope="row">{$i++}</th>
                            <td>{if $user->getNomeReal()}{$user->getNomeAbreviado()}{else}USUARIO {$user->getId()}{/if}</td>
                            <td>{$user->getIraPeriodoPassado()|string_format:"%.2f"}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>

        <hr>
        <h4 class="text-center">Amigos</h4> <h6 class="text-center">Digite o nome da pessoa no campo abaixo para adicioná-lo como amigo!</h6>

        <form class="form-row" method="post" style="margin-top: 30px;">
            <input id="pesquisa" name="pesquisa" type="text" class="form-control col-md-8" placeholder="Pesquisar">
            <button style="margin-left: 1%" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </form>

        {if isset($usuariosPesquisados)}
            <table id="friends" style="margin-top: 4%" class="table table-hover">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                {foreach $usuariosPesquisados as $user}
                    <tr>
                        <td>{$user['nome']}</td>

                        {if $user['estado'] == 'nao enviado'}
                            <td><a href="{path_for name="conviteAmizade" data=["id-remetente" => $usuario->getId(), "id-destinatario" => $user['id']]}" class="btn btn-primary">Adicionar</a></td>
                        {/if}

                        {if $user['estado'] == 'aceito'}
                            <td><p>Já é seu amigo!</p></td>
                        {/if}

                        {if $user['estado'] == 'pendente'}
                            <td><p>Convite pendente</p></td>
                        {/if}

                    </tr>
                    {foreachelse}
                    <tr>
                        <td scope="row" colspan="4" class="text-center">Nenhum usuário encontrado!</td>
                    </tr>
                {/foreach}
            </table>
        {/if}

    </div>

    <!-- Modal -->
    <div class="modal fade" id="chagePhotoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Alterar Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="uploadPhoto" method="POST">
                    <div class="modal-body">
                        <div class="custom-file mb-2">
                            <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*">
                            <label class="custom-file-label" for="photo">Selecionar Foto</label>
                        </div>
                        <div id="image-cropper"></div>
                        <input type="hidden" id="newPhoto" name="newPhoto"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Alterar Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{/block}

{block name=javascript}
    <script src="{base_url}/js/croppie.js"></script>
    <script src="{base_url}/js/exif.js"></script>

    <script>
        var $uploadCrop;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    });
                };

                reader.readAsDataURL(input.files[0]);
            }
            else {
                console.log("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('#image-cropper').croppie({
            viewport: { width: 190, height: 190 },
            boundary: { width: 450, height: 300 },
            enableExif: true
        });

        $('#photo').on('change', function () {
            $('#newPhoto').val('');
            readFile(this);
        });

        $('#uploadPhoto').submit(function() {
            if($('#newPhoto').val() !== '') {
                return true;
            } else {
                $uploadCrop.croppie('result', 'base64').then(function (base64) {
                    $('#newPhoto').val(base64);
                    $('#photo').val('');
                    $('#uploadPhoto').submit();
                });

                return false;
            }
        });
    </script>
{/block}