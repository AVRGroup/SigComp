<?php

namespace App\Controller;

use App\Library\Integra\getUserInformation;
use App\Library\Integra\login;
use App\Library\Integra\logout;
use App\Library\Integra\WSLogin;
use App\Model\Usuario;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function loginAction(Request $request, Response $response, $args)
    {
        if ($request->isPost()) {
            $loginCredentials = new login();
            $loginCredentials->setCpf($request->getParsedBodyParam('cpf'));
            $loginCredentials->setSenha(md5($request->getParsedBodyParam('password')));
            $loginCredentials->setAppToken($this->container->get('settings')['integra']['token']);
            $WSLogin = new WSLogin();

            try {
                $loginResponse = $WSLogin->login($loginCredentials)->getReturn();
                $userInfoResponse = $WSLogin->getUserInformation((new getUserInformation())->setToken($loginResponse->getToken()))->getReturn();
                $WSLogin->logout((new logout())->setToken($loginResponse->getToken()));

                $matriculas = [];
                foreach ($userInfoResponse->getProfileList()->getProfile() as $profile) {
                    $matriculas[] = $profile->getMatricula();
                }

                $matriculas[] = '200935027';
                $matriculas[] = '200935040';

                /** @var Usuario[] $usuarios */
                $usuarios = $this->container->get('UsuarioDAO')->getByMatricula($matriculas);

                if (count($usuarios) != 0) {
                    $_SESSION['id'] = $usuarios[0]->getId();
                    $_SESSION['profiles'] = [];

                    foreach ($usuarios as $usuario) {
                        $profileInfo = [
                            'id' => $usuario->getId(),
                            'matricula' => $usuario->getMatricula(),
                            'curso' => $usuario->getCurso(),
                            'type' => $usuario->getTipo()
                        ];
                        $_SESSION['profiles'][$usuario->getMatricula()] = $profileInfo;

                        $usuario->setEmail($userInfoResponse->getEmailSiga());
                    }
                    $this->container->get('UsuarioDAO')->flush();

                    return $response->withRedirect($this->container->get('router')->pathFor('home'));
                } else {
                    $this->container->get('view')['error'] = 'Você não possui nenhuma matrícula válida!';
                }
            } catch (\SoapFault $e) {
                $this->container->get('view')['error'] = $e->getMessage();
            }
        }

        return $this->container->get('view')->render($response, 'login.tpl');
    }

    public function logoutAction(Request $request, Response $response, $args)
    {
        unset($_SESSION['id']);

        return $response->withRedirect($this->container->get('router')->pathFor('login'));
    }

    public function listProfilesAction(Request $request, Response $response, $args)
    {
        $this->container->get('view')['profiles'] = $_SESSION['profiles'];

        return $this->container->get('view')->render($response, 'changeProfile.tpl');
    }

}
