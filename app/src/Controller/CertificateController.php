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

    public function listAction(Request $request, Response $response, $args)
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

                if(!in_array($extension, $this->container->settings['upload']['allowedCertificationExtensions']) || $uploadedFile->getSize() > $this->container->settings['upload']['maxBytesSize']) {
                    $this->container->view['error'] = 'Formato ou Tamanho do certificado inválido!';
                } else {
                    try {
                        $certificado = new Certificado();
                        $certificado->setUsuario($request->getAttribute('user'));
                        $certificado->setExtensao($extension);
                        $certificado->setTipo($request->getParsedBodyParam('type'));
                        $certificado->setNumHoras($request->getParsedBodyParam('num_horas'));

                        $dataFormatada = date("Y-m-d", strtotime($request->getParsedBodyParam('data_inicio') ));
                        $certificado->setDataInicio($dataFormatada);

                        $dataFormatada = date("Y-m-d", strtotime($request->getParsedBodyParam('data_inicio1') ));
                        $certificado->setDataInicio1($dataFormatada);

                        $dataFormatada = date("Y-m-d", strtotime($request->getParsedBodyParam('data_inicio2') ));
                        $certificado->setDataInicio2($dataFormatada);

                        $dataFormatada = date("Y-m-d", strtotime($request->getParsedBodyParam('data_fim') ));
                        $certificado->setDataFim($dataFormatada);

                        $dataFormatada = date("Y-m-d", strtotime($request->getParsedBodyParam('data_fim1') ));
                        $certificado->setDataFim1($dataFormatada);

                        $dataFormatada = date("Y-m-d", strtotime($request->getParsedBodyParam('data_fim2') ));
                        $certificado->setDataFim2($dataFormatada);

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
        $this->container->view['certificates'] = $this->container->certificadoDAO->getAllByUsuario($request->getAttribute('user'));
        return $this->container->view->render($response, 'certificates.tpl');
    }

    public function deleteAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);

        if($certificado && $certificado->getUsuario()->getId() == $request->getAttribute('user')->getId()
            && ($certificado->isInReview() || !$certificado->getValido())) {
            $this->container->certificadoDAO->delete($certificado);
            unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());
        }

        return $response->withRedirect($this->container->router->pathFor('listCertificates'));
    }

    // Administração

    public function adminListReviewAction(Request $request, Response $response, $args)
    {
        $this->container->view['certificates'] = $this->container->certificadoDAO->getAllToReview();

        foreach ($this->container->certificadoDAO->getAllToReview() as $certificate)
            var_dump($certificate->getNumHoras());

        $this->container->view['certTypes'] = Certificado::getAllTipos();
        return $this->container->view->render($response, 'adminCertificates2.tpl');
    }

    public function adminDeleteAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);

        if($certificado) {
            $this->container->certificadoDAO->delete($certificado);
            unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());
            $redirect = $this->container->router->pathFor('adminUser', ['id' => $certificado->getUsuario()->getId()]);
        } else {
            $redirect = $this->container->router->pathFor('adminListUsers');
        }

        if(!is_null($request->getQueryParam('isReviewPage')))
            $redirect = $this->container->router->pathFor('adminListReviewCertificates');

        return $response->withRedirect($redirect);
    }

    public function adminChangeAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);

        if($certificado) {
            $certificado->setValido($args['state'] == 'true'? true : false);
            $this->container->certificadoDAO->save($certificado);
            $redirect = $this->container->router->pathFor('adminUser', ['id' => $certificado->getUsuario()->getId()]);
        } else {
            $redirect = $this->container->router->pathFor('adminListUsers');
        }

        if(!is_null($request->getQueryParam('isReviewPage')))
            $redirect = $this->container->router->pathFor('adminListReviewCertificates');

        return $response->withRedirect($redirect);    }

}
