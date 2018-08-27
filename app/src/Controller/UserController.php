<?php

namespace App\Controller;

use App\Library\CalculateAttributes;
use App\Library\Integra\getUserInformation;
use App\Library\Integra\getUserInformationResponse;
use App\Library\Integra\login;
use App\Library\Integra\logout;
use App\Library\Integra\WSLogin;
use App\Library\Integra\wsUserInfoResponse;
use App\Model\Certificado;
use App\Model\Nota;
use App\Model\Usuario;
use App\Model\GradeDisciplina;
use App\Model\Grade;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function adminListAction(Request $request, Response $response, $args)
    {
        $this->container->view['users'] = $this->container->usuarioDAO->getAll();
        return $this->container->view->render($response, 'adminListUsers.tpl');
    }

    public function adminUserAction(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getByIdFetched($args['id']);

        if(!$usuario) {
            return $response->withRedirect($this->container->router->pathFor('adminListUsers'));
        }

        CalculateAttributes::calculateUsuarioStatistics($usuario);

        $medalhasUsuario = $this->container->usuarioDAO->getMedalsByIdFetched($usuario->getId());
        $this->container->view['medalhas'] = $medalhasUsuario;

        $this->container->view['user'] = $usuario;
        return $this->container->view->render($response, 'adminUser.tpl');
    }

    public function adminTestAction(Request $request, Response $response, $args)
    {
        $allUsers = $this->container->usuarioDAO->getAllFetched();

        /** @var Usuario $user */
        foreach ($allUsers as $user) {
            $exp = 0;
            /** @var Nota $notas */
            foreach ($user->getNotas() as $notas) {
                $exp += $notas->getValor();
            }

            $user->setExperiencia($exp);
        }

        $this->container->usuarioDAO->flush();

        $this->container->view['usuariosFull'] = $allUsers;

        return $this->container->view->render($response, 'adminTest.tpl');
    }

    public function checkPeriodosTestAction(Request $request, Response $response, $args)
    {
        $allUsers = $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(1, 7), 1);
        $allGrades = $this->container->gradeDAO->getAll();

        $this->container->view['usuariosFull'] = $allUsers;
        $this->container->view['gradesFull'] = $allGrades;

        return $this->container->view->render($response, 'checkPeriodos.tpl');
    }

    public function informacoesPessoaisAction(Request $request, Response $response, $args)
    {
        $user = $request->getAttribute('user');

        $usuario = $this->container->usuarioDAO->getByIdFetched($user->getId());

        $this->container->view['usuario'] = $usuario;

        return $this->container->view->render($response, 'informacoesPessoais.tpl');
    }

    public function assignMedalsAction(Request $request, Response $response, $args){
        $this->container->medalhaUsuarioDAO->truncateTable();

        $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(1, 7), 1);
        $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(2, 6), 2);
        $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(3, 6), 3);
        $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(4, 5), 4);
        $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(5, 5), 5);
        $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(6, 5), 6);
        $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(7, 4), 7);
        $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(8, 4), 8);
        $this->container->usuarioDAO->setPeriodo($this->container->usuarioDAO->getPeriodo(9, 1), 9);

        $this->container->usuarioDAO->setByIRA($this->container->usuarioDAO->getByIRA(60), 60);
        $this->container->usuarioDAO->setByIRA($this->container->usuarioDAO->getByIRA(70), 70);
        $this->container->usuarioDAO->setByIRA($this->container->usuarioDAO->getByIRA(80), 80);

        return $this->container->view->render($response, 'assignMedals.tpl');
    }
}

