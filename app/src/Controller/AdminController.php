<?php

namespace App\Controller;

use App\Library\Helper;
use App\Model\Disciplina;
use App\Model\Nota;
use App\Model\Usuario;
use Doctrine\Common\Collections\ArrayCollection;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class AdminController
{

    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function dataLoadAction(Request $request, Response $response, $args)
    {
        if ($request->isPost() && isset($request->getUploadedFiles()['data'])) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $request->getUploadedFiles()['data'];

            if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                $this->container->view['error'] = 'Erro no upload do arquivo, tente novamente!';
            } else {
                $extension = mb_strtolower(pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION));

                if (!in_array($extension, $this->container->settings['upload']['allowedDataLoadExtensions'])) {
                    $this->container->view['error'] = 'Formato ou Tamanho do certificado inválido!';
                } else {
                    try {
                        set_time_limit(60 * 60); //Should not Exit
                        $data = Helper::processCSV($uploadedFile->file);
                        $affectedData = ['disciplinasAdded' => 0, 'usuariosAdded' => 0, 'usuariosUpdated' => 0];

                        $disciplinas = Helper::convertToIdArray($this->container->disciplinaDAO->getAll());

                        foreach ($data['disciplinas'] as $disc) {
                            if(isset($disciplinas[$disc['codigo']]))
                                continue;

                            $disciplina = new Disciplina();
                            $disciplina->setCodigo($disc['codigo']);
                            $disciplina->setCarga($disc['carga']);
                            $this->container->disciplinaDAO->persist($disciplina);

                            $disciplinas[$disciplina->getIdentifier()] = $disciplina; //Added to existing Disciplinas
                            $affectedData['disciplinasAdded'] ++;
                        }
                        $this->container->disciplinaDAO->flush(); //Commit the transaction

                        $usuarios = Helper::convertToIdArray($this->container->usuarioDAO->getAllFetched());

                        foreach ($data['usuarios'] as $user) {
                            if(isset($usuarios[$user['matricula']])) {
                                $usuario = $usuarios[$user['matricula']];
                                foreach ($usuario->getNotas() as $userNota) {
                                    $usuario->removeNota($userNota);
                                    $this->container->notaDAO->remove($userNota);
                                }
                                $usuario->setNome($user['nome']);
                                $usuario->setGrade($user['grade']);
                                $affectedData['usuariosUpdated']++;
                            } else {
                                $usuario = new Usuario();
                                $usuario->setCurso($user['curso']);
                                $usuario->setMatricula($user['matricula']);
                                $usuario->setNome($user['nome']);
                                $usuario->setGrade($user['grade']);

                                $this->container->usuarioDAO->persist($usuario);
                                $affectedData['usuariosAdded']++;
                            }
                            foreach ($user['disciplinas'] as $disc) {
                                $nota = new Nota();
                                $nota->setEstado($disc['status']);
                                $nota->setValor($disc['nota']);
                                $nota->setPeriodo($disc['periodo']);
                                $nota->setDisciplina($disciplinas[$disc['codigo']]);
                                $usuario->addNota($nota);

                                $this->container->notaDAO->persist($nota);
                            }
                        }

                        $this->container->usuarioDAO->flush(); //Commit the transaction
                        $this->container->view['affectedData'] = $affectedData;
                        $this->container->view['success'] = true;
                    } catch (\Exception $e) {
                        $this->container->view['error'] = $e->getMessage();
                    }
                }
            }
        }
        return $this->container->view->render($response, 'adminDataLoad.tpl');
    }
}