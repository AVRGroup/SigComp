<?php

namespace App\Controller;

use App\Library\Integra\getUserInformation;
use App\Library\Integra\login;
use App\Library\Integra\logout;
use App\Library\Integra\WSLogin;
use App\Model\Usuario;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function loginAction(Request $request, Response $response, $args)
    {
        $oportunidade = $request->getParam('oportunidade');

        if(isset($oportunidade) && isset($_SESSION['id'])){
            return $response->withRedirect("todas-oportunidades?oportunidade=$oportunidade");
        }

        if ($request->isPost()) {
            try {
                $cpf = $request->getParsedBodyParam('cpf');

                if($this->isLoginAdministrativo($cpf)) {
                    return $this->loginAreaExclusiva($request, $response, $args);
                }

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
                    

                    if(isset($oportunidade)){
                        return $response->withRedirect("todas-oportunidades?oportunidade=$oportunidade");
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

    public function isLoginAdministrativo($login)
    {
        $loginsAdministrativos = ["coord", "bolsa", "admin"];

        foreach ($loginsAdministrativos as $palavra) {
            if(strpos($login, $palavra ) !== false) {
                return true;
            }
        }

        return false;
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

    public function areaExclusiva(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, "areaExclusiva.tpl");
    }

    public function loginAreaExclusiva(Request $request, Response $response, $args)
    {

        $login = $request->getParsedBodyParam('cpf');
        $senha = $request->getParsedBodyParam('password');
        $senha = crypt($senha, $this->container->settings['password_salt']);
        $usuario = $this->container->usuarioDAO->getUserByLoginSenha($login, $senha);

        if($usuario == null) {
            $this->container->view['error'] = "Verifique se o login e a senha estão corretos";
            return $this->container->view->render($response, "login.tpl");
        }

        $_SESSION['id'] = $usuario->getId();

        $oportunidade = $request->getParam('oportunidade');

        if(isset($oportunidade)){
            return $response->withRedirect("oportunidade/$oportunidade");
        }
        return $this->getRedirecionamentoPorUsuario($usuario, $response);
    }

    public function getRedirecionamentoPorUsuario(Usuario $usuario, $response)
    {
        if($usuario->isAdmin()) {
            return $response->withRedirect($this->container->router->pathFor('adminDashboard'));
        }

        if($usuario->isBolsista()){
            return $response->withRedirect($this->container->router->pathFor('adminListReviewCertificates'));
        }

        if($usuario->isCoordenador()){
            return $response->withRedirect($this->container->router->pathFor('adminDashboard'));
        }

        return $response->withRedirect($this->container->router->pathFor('home'));
    }
}
