<?php

namespace App\Controller;

use App\Library\Integra\getUserInformation;
use App\Library\Integra\getUserInformationResponse;
use App\Library\Integra\login;
use App\Library\Integra\logout;
use App\Library\Integra\WSLogin;
use App\Library\Integra\wsUserInfoResponse;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Forum;

class LoginController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function loginAction(Request $request, Response $response, $args)
    {
        if ($request->isPost()) {
            $loginCredentials = new login();
            $loginCredentials->setCpf($request->getParsedBodyParam('cpf'));
            $loginCredentials->setSenha(md5($request->getParsedBodyParam('password')));
            $loginCredentials->setAppToken($this->container->settings['integra']['token']);
            $WSLogin = new WSLogin();

            try {
                //TODO REMOVE THIS ON PRODUCTION
                if($request->getParsedBodyParam('cpf') == '123' && $request->getParsedBodyParam('password') == '456') {
                    $matriculas[] = '201535025';
                    $userInfoResponse = new wsUserInfoResponse(12345);
                    $userInfoResponse->setEmailSiga('a@a.com');
                } else {
                    $loginResponse = $WSLogin->login($loginCredentials)->getReturn();
                    $userInfoResponse = $WSLogin->getUserInformation((new getUserInformation())->setToken($loginResponse->getToken()))->getReturn();
                    $WSLogin->logout((new logout())->setToken($loginResponse->getToken()));

                    $matriculas = [];
                    foreach ($userInfoResponse->getProfileList()->getProfile() as $profile) {
                        $matriculas[] = $profile->getMatricula();
                    }
                }

                $usuarios = $this->container->usuarioDAO->getByMatricula($matriculas);

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
                    $this->container->usuarioDAO->flush();

                    $r = new HttpRequest('http://200.131.219.56/flarum', HttpRequest::METH_POST);
                    $r->addPostFields(array('identification' => 'projeto', 'password' => 'prj#game'));
                    try {
                        //echo $r->send()->getBody();
                        $this->container->view['error'] = $r->send()->getBody();
                    } catch (HttpException $ex) {
                        //echo $ex;
                        $this->container->view['error'] = 'dashuhudsas!';
                    }

                    //return $response->withRedirect($this->container->router->pathFor('home'));
                    //return $this->container->view->render($response, 'login.tpl');
                } else {
                    $this->container->view['error'] = 'Você não possui nenhuma matrícula válida!';
                }
            } catch (\Exception $e) {
                $this->container->view['error'] = $e->getMessage();
            }
        }

        return $this->container->view->render($response, 'login.tpl');
    }

    public function logoutAction(Request $request, Response $response, $args)
    {
        unset($_SESSION['id']);

        return $response->withRedirect($this->container->router->pathFor('login'));
    }

    public function listProfilesAction(Request $request, Response $response, $args)
    {
        $this->container->view['profiles'] = $_SESSION['profiles'];

        return $this->container->view->render($response, 'changeProfile.tpl');
    }

}
