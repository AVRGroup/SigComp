{extends 'layout.tpl'}
{block name=content}
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="text-center">
                    <div class="changePic">
                        <div class="changePicButton text-center" data-toggle="modal" data-target="#chagePhotoModal">
                            <i class="fas fa-camera" style="font-size: 30px;"></i>
                            <p>Alterar Foto</p>
                        </div>
                        <img src="{base_url}/{if $loggedUser->getFoto()}upload/{$loggedUser->getFoto()}{else}img/silhueta.jpg{/if}"
                             class="img-thumbnail" alt="{$loggedUser->getNome()}" width="190" height="190">
                    </div>
                    {$loggedUser->getNome()}
                </div>
            </div>
            <div class="col-9">
                <h4 class="text-center">Estatíticas</h4>
                <p class="mb-0 mt-3"><b>Experiência:</b> {$usuario->getExperiencia()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getExperiencia())/($usuario->getExperiencia() +500 ) }%;">{((100 * $usuario->getExperiencia())/($usuario->getExperiencia() +500 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Inteligência:</b> {$usuario->getInteligencia()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {((100*$usuario->getInteligencia())/17)}%;">{((100 * $usuario->getInteligencia())/17)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Sabedoria:</b> {$usuario->getSabedoria()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getSabedoria())/16}%;">{((100 * $usuario->getSabedoria())/16)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Destreza:</b> {$usuario->getDestreza()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getDestreza())/14}%;">{((100 * $usuario->getDestreza())/14)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Força:</b> {$usuario->getForca()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getForca())/11}%;">{((100 * $usuario->getForca())/11)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Carisma:</b> {$usuario->getCarisma()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getCarisma())/2}%;">{((100 * $usuario->getCarisma())/2)|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Cultura:</b> {$usuario->getCultura()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getCultura())/($usuario->getCultura() +50 ) }%;">{((100 * $usuario->getCultura())/($usuario->getCultura() + 50 ))|string_format:"%.2f"}%</div>
                </div>

                <h4 class="text-center mt-3">Notas dos usuários</h4>
                <ul>
                    {foreach $usuario->getNotas() as $nota}
                        <li>{$nota->getDisciplina()->getCodigo()}({$nota->getEstado()} - {$nota->getPeriodo()}) -> {$nota->getValor()} </li>
                    {/foreach}
                </ul>
            </div>

        </div>
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