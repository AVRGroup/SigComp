<?php

namespace App\Controller;

use App\Library\Integra\getUserInformation;
use App\Library\Integra\getUserInformationResponse;
use App\Library\Integra\login;
use App\Library\Integra\logout;
use App\Library\Integra\WSLogin;
use App\Library\Integra\wsUserInfoResponse;
use App\Model\Certificado;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class CertificateController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function indexAction(Request $request, Response $response, $args)
    {
        if ($request->isPost() && isset($request->getUploadedFiles()['certificate'])) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $request->getUploadedFiles()['certificate'];
            if($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                $this->container->view['error'] = 'Erro no upload do certificado, tente novamente!';
            } else if ($request->getParsedBodyParam('type') == null || !isset(Certificado::getAllTipos()[$request->getParsedBodyParam('type')])){
                $this->container->view['error'] = 'Selecione o tipo de certificado!';
            } else {
                $extension = mb_strtolower(pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION));

                if(!in_array($extension, $this->container->settings['upload']['allowedExtensions']) || $uploadedFile->getSize() > $this->container->settings['upload']['maxBytesSize']) {
                    $this->container->view['error'] = 'Formato ou Tamanho do certificado inválido!';
                } else {
                    try {
                        $certificado = new Certificado();
                        $certificado->setUsuario($request->getAttribute('usuario'));
                        $certificado->setExtensao($extension);
                        $certificado->setTipo($request->getParsedBodyParam('type'));

                        do {
                            $uuid4 = Uuid::uuid4();
                            $certificado->setNome($uuid4->toString() . '.' . $extension); //Make sure we got an unique name
                        } while (file_exists($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome()));

                        $uploadedFile->moveTo($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());

                        $this->container->certificadoDAO->save($certificado);
                        $this->container->view['success'] = true;

                    } catch (\Exception $e) {
                        unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());
                        $this->container->view['error'] = 'Erro ao salvar certificado, tente novamente!';
                    }
                }
            }
        }

        $this->container->view['certTypes'] = Certificado::getAllTipos();
        $this->container->view['certificates'] = $this->container->certificadoDAO->getAllByUsuario($request->getAttribute('usuario'));
        return $this->container->view->render($response, 'certificates.tpl');
    }

    public function deleteAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);

        if($certificado && $certificado->getUsuario()->getId() == $request->getAttribute('usuario')->getId()
            && ($certificado->isInReview() || !$certificado->getValido())) {
            $this->container->certificadoDAO->delete($certificado);
            unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());
        }

        return $response->withRedirect($this->container->router->pathFor('listCertificates'));
    }

    // Administração

    public function adminDeleteAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);

        if($certificado) {
            $this->container->certificadoDAO->delete($certificado);
            unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());
        }

        return $response->withRedirect($this->container->router->pathFor('adminCertificates'));
    }

    public function adminChangeAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);

        if($certificado) {
            $certificado->setValido($args['state'] == 'true'? true : false);
            $this->container->certificadoDAO->save($certificado);
        }

        return $response->withRedirect($this->container->router->pathFor('adminCertificates'));
    }

    public function adminListReviewAction(Request $request, Response $response, $args)
    {
        $this->container->view['certificates'] = $this->container->certificadoDAO->getAllToReview();
        return $this->container->view->render($response, 'adminCertificates.tpl');
    }
}
