<?php

namespace App\Controller;

use App\Library\CalculateAttributes;
use App\Library\Helper;
use App\Model\Disciplina;
use App\Model\Nota;
use App\Model\Usuario;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function indexAction(Request $request, Response $response, $args)
    {
        /** @var Usuario $user */
        $user = $request->getAttribute('user');

        if ($request->isPost()) {
            try {
                $newPhotoBase64 = $request->getParsedBodyParam('newPhoto');
                list(, $data) = explode(',', $newPhotoBase64);
                $newPhoto = base64_decode($data);

                $im = imagecreatefromstring($newPhoto);
                if ($im !== false) {
                    $lastFoto = $user->getFoto();

                    do {
                        $uuid4 = Uuid::uuid4();
                        $user->setFoto($uuid4->toString() . '.png'); //Make sure we got an unique name
                    } while (file_exists($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $user->getFoto()));

                    file_put_contents($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $user->getFoto(), $newPhoto);

                    $this->container->usuarioDAO->save($user);
                    imagedestroy($im);

                    //Delet Last Foto
                    if($lastFoto) {
                        unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $lastFoto);
                    }
                }
            } catch (\Exception $e) {
                echo $e->getTraceAsString();
                // TODO Error message
            }
        }

        $usuario = $this->container->usuarioDAO->getByIdFetched($user->getId());
        CalculateAttributes::calculateUsuarioStatistics($usuario);
        $this->container->view['usuario'] = $usuario;

        return $this->container->view->render($response, 'home.tpl');
    }

    public function aboutAction(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'about.tpl');
    }

    public function testAction(Request $request, Response $response, $args)
    {
        set_time_limit(60 * 60);
        $data = Helper::processCSV('/Users/matheus/Desktop/lidiane/dados_alunos_35A1510690190786.csv');

        foreach ($data['disciplinas'] as $disc) {
            $disciplina = new Disciplina();
            $disciplina->setCodigo($disc['codigo']);
            $disciplina->setCarga($disc['carga']);
            $this->container->disciplinaDAO->persist($disciplina);
        }
        $this->container->disciplinaDAO->flush();

        $disciplinas = Helper::convertToIdArray($this->container->disciplinaDAO->getAll());

        foreach ($data['usuarios'] as $user) {
            $usuario = new Usuario();
            $usuario->setCurso($user['curso']);
            $usuario->setMatricula($user['matricula']);
            $usuario->setNome($user['nome']);
            $usuario->setGrade($user['grade']);

            foreach ($user['disciplinas'] as $disc) {
                $nota = new Nota();
                $nota->setEstado($disc['status']);
                $nota->setValor($disc['nota']);
                $nota->setDisciplina($disciplinas[$disc['codigo']]);
                $usuario->addNota($nota);

                $this->container->notaDAO->persist($nota);
            }

            $this->container->usuarioDAO->save($usuario);
        }
        return $this->container->view->render($response, 'home.tpl');
    }


}
