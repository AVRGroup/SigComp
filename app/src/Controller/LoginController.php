<?php

namespace App\Controller;

use App\Library\FlarumHelper;
use App\Library\Integra\getUserInformation;
use App\Library\Integra\getUserInformationResponse;
use App\Library\Integra\login;
use App\Library\Integra\logout;
use App\Library\Integra\WSLogin;
use App\Library\Integra\wsUserInfoResponse;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Cookies;
use App\Controller\Forum;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

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
            /*$loginCredentials = new login();
            $loginCredentials->setCpf($request->getParsedBodyParam('cpf'));
            $loginCredentials->setSenha(md5($request->getParsedBodyParam('password')));
            $loginCredentials->setAppToken($this->container->settings['integra']['token']);
            $WSLogin = new WSLogin();*/


            try {
                if ($request->getParsedBodyParam('cpf') == 'admin' && $request->getParsedBodyParam('password') == '01#!/79awQxVp') {
                    $matriculas[] = '100000000';
                    $userInfoResponse = new wsUserInfoResponse(12345);
                    $userInfoResponse->setEmailSiga('a@a.com');

                } else {
                    if($request->getParsedBodyParam('cpf') == 'bolsa' && $request->getParsedBodyParam('password') == '56#$2dEMy#!') {
                        $matriculas[] = '200000000';
                        $userInfoResponse = new wsUserInfoResponse(12345);
                        $userInfoResponse->setEmailSiga('a@a.com');
                    }
                    else {
                        $loginCredentials = new login();
                        $loginCredentials->setCpf($request->getParsedBodyParam('cpf'));
                        $loginCredentials->setSenha(md5($request->getParsedBodyParam('password')));
                        $loginCredentials->setAppToken($this->container->settings['integra']['token']);
                        $WSLogin = new WSLogin();

                        $loginResponse = $WSLogin->login($loginCredentials)->getReturn();
                        $userInfoResponse = $WSLogin->getUserInformation((new getUserInformation())->setToken($loginResponse->getToken()))->getReturn();
                        $WSLogin->logout((new logout())->setToken($loginResponse->getToken()));

                        $matriculas = [];
                        foreach ($userInfoResponse->getProfileList()->getProfile() as $profile) {
                            $matriculas[] = $profile->getMatricula();
                        }
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

                        $usuario->setQuantidadeAcessos($usuario->getQuantidadeAcessos() + 1);

                        $this->container->usuarioDAO->persist($usuario);
                        $this->container->usuarioDAO->flush(); //Commit the transaction
                    }
                    $this->container->usuarioDAO->flush();

                    if($usuarios[0]->getNome()== "ADMINISTRADOR"){
                        return $response->withRedirect($this->container->router->pathFor('adminDashboard'));
                    }
                    else if ($usuarios[0]->getNome()== "BOLSISTA"){
                        return $response->withRedirect($this->container->router->pathFor('adminListReviewCertificates'));
                    }

                    return $response->withRedirect($this->container->router->pathFor('home'));

                } else {
                    $this->container->view['error'] = 'Você não possui nenhuma matrícula válida!';
                }
            } catch (\Exception $e) {
                $this->container->view['error'] = "CPF ou senha errados. Use o mesmo login do Siga :D";
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
