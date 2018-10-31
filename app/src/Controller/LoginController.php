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
                //TODO REMOVE THIS ON PRODUCTION
                if($request->getParsedBodyParam('cpf') == '123' && $request->getParsedBodyParam('password') == '456') {
                    $matriculas[] = '201535025';
                    $userInfoResponse = new wsUserInfoResponse(12345);
                    $userInfoResponse->setEmailSiga('a@a.com');
                } else {
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

                    /*$client = new Client([
                        // Base URI is used with relative requests
                        'base_uri' => 'http://200.131.219.56',
                        // You can set any number of default request options.
                        'timeout'  => 2.0,
                    ]);

                    $cookieJar = new CookieJar();
                    $result = $client->request('POST', '/flarum', [
                        'cookies' => $cookieJar,
                        'form_params' => [
                            'identification' => 'projeto',
                            'password' => 'prj#game'
                        ]
                    ]);

                    echo $result->getHeader('Cookie');

                    $cookies = new Cookies();

                    foreach ($cookieJar->toArray() as $key => $value)
                    {
                        $cookies->set($key, $value);
                    }

                    return $response
                            ->withHeader('Set-Cookie', cookies)
                            ->withRedirect($this->container->router->pathFor('home'));*/
                    $api_url = "http://200.131.219.56/flarum/api/token";
                    $username = "projeto";
                    $password = "prj#game";

                    // CURL call
                    $ch = curl_init($api_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json'
                    ]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                        'identification' => $username,
                        'password'       => $password
                    ]));
                    $result = curl_exec($ch);
                    $session = json_decode($result);
                    $session->token; // API Token
                    $session->userId; // Authenticated user ID

                    $api_url = "http://200.131.219.56/flarum/api/users";
                    $token = $session->token;

                    $expire = time() + (86400 * 30);
                    setcookie('flarum_remember', $token, $expire, "/");
                    header("Location: https://200.131.219.56/flarum");

                    /*$new_username = "teste";
                    $new_password = "123456";
                    $new_email = "john.smith@example.org";
                    $ch = curl_init($api_url);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Authorization: Token ' . $token
                    ]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                        'data' => [
                            'attributes' => [
                                "username" => $new_username,
                                "password" => $new_password,
                                "email"    => $new_email,
                                "isActivated" => true
                            ]
                        ]
                    ]));
                    $result = curl_exec($ch);
                    $new_user = json_decode($result);
                    $new_user;*/

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
