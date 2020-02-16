{extends 'layout.tpl'}
{block name=content}

    <h3 align="center">Informações Pessoais</h3>
    <hr>

    <div class="row container">
        <h5 class="col-md-6 col-xs-12">Nome: <span class="font-weight-normal">{$usuario->getNome()}</span></h5>
        <h5 class="col-md-6 col-xs-12 float-right">Matrícula: <span class="font-weight-normal">{$usuario->getMatricula()}</></h5>
        <h5 class="col-md-6 col-xs-12">Curso: <span class="font-weight-normal">{$usuario->getCurso()}</></h5>
        <h5 class="col-md-6 col-xs-12">E-mail: <span class="font-weight-normal">{$usuario->getEmail()}</></h5>
        <h5 class="col-md-6 col-xs-12">Indíce de Rendimento Acadêmico: <span class="font-weight-normal">{$usuario->getIra()|string_format:"%.2f"}</></h5>
        <h5 class="col-md-6 col-xs-12">Grade: <span class="font-weight-normal">{$usuario->getGrade()}</></h5>
    </div>

    <hr>
    <div style="border: 0.5px solid; margin-top: 3%">
        <h4 align="center" style="margin-top: 2%">Atualize seus dados</h4>
        <h6 align="center" style="margin-bottom: 2%"> Todas essas informações são opcionais </h6>
    </div>

    {if isset($success)}
        <div class="alert alert-success" role="alert" style="margin-top: 3%">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p>{$success}</p>
        </div>
    {/if}

    {if isset($errors) && !empty($errors)}
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 3%">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                {foreach $errors as $error}
                    <li>Erro na rede {$error}, por favor verifique se o link está no formato correto</li>
                {/foreach}
            </ul>
        </div>
    {/if}

    <form method="post">
        <div class="form-row">
            <div class="col-md-6 col-sm-11 mx-sm-auto mx-md-0 mt-sm-4 mt-md-3 mt-3">
                <h6> <label for="email">E-mail</label> </h6>
                <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu e-mail" value="{$usuario->getEmail()}">
            </div>

            <div class="custom-control custom-checkbox mt-md-5 mt-sm-3 ml-sm-5 ml-md-0 mt-2 ml-2">
                <input id="nome-real" type="checkbox" name="nome_real" class="custom-control-input" {$checked}>
                <label class="custom-control-label" for="nome-real">Desejo que meu nome não seja mostrado</label>
            </div>

        </div>

        <button style="margin-top: 2%" type="button" class="btn btn-success" data-toggle="modal" data-target="#chagePhotoModal">
            Alterar Foto de Perfil
        </button>

        <div class="form-row" style="margin-top: 3%">
            <div class="col-md-6 col-sm-11 mx-sm-auto ">
               <h6> <label for="facebook">Facebook</label> </h6>
                <input type="text" name="facebook" placeholder="https://facebook.com/seu.perfil" class="form-control" value="{$usuario->getFacebook()}">
            </div>

            <div class="col-md-6 col-sm-11 mt-sm-3 mt-md-0 mx-sm-auto" style="margin-top: 10px;">
                <h6> <label for="instagram">Instagram</label> </h6>
                <input type="text" name="instagram" placeholder="https://instagram.com/seu.perfil" class="form-control" value="{$usuario->getInstagram()}">
            </div>
        </div>

        <div class="form-row" style="margin-top: 3%">
            <div class="col-md-6 col-sm-11 mx-sm-auto">
                <h6> <label for="linkedin">LinkedIn</label> </h6>
                <input type="text" name="linkedin" placeholder="https://linkedin.com/seu.perfil" class="form-control" value="{$usuario->getLinkedin()}">
            </div>

            <div class="col-md-6 col-sm-11 mt-sm-3 mt-md-0 mx-sm-auto" style="margin-top: 10px;">
                <h6> <label for="lattes">Lattes</label> </h6>
                <input type="text" name="lattes" placeholder="http://lattes.cnpq.br/seu.perfil" class="form-control" value="{$usuario->getLattes()}">
            </div>
        </div>

        <hr>
        <h5 align="center" class="mt-sm-4 mt-md-3">Sobre mim</h5>

        <div class="form-group">
            <div class="col-xs-12 mx-auto text-sm-center">
                <textarea class="form-control" name="sobre_mim"  id="sobre-mim" rows="7" placeholder="Máximo 50 caracteres" >{$usuario->getSobreMim()}</textarea>
            </div>
        </div>
                <div class="text-sm-center text-md-center">
            <small id="contador-mensagem"></small>
        </div>
        <hr>

        <div class="text-sm-center" >
            <button class="btn btn-primary btn-lg btn-block" type="submit">Atualizar</button>
        </div>
    </form>

    <div class="modal fade" id="chagePhotoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered"  role="document">
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
            boundary: { width: 300, height: 200 },
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

