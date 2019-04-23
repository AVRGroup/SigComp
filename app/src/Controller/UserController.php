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
use App\Persistence\UsuarioDAO;
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

        if($request->isPost()){
            $pesquisa = $request->getParsedBodyParam('pesquisa');
            $this->container->view['users'] = $this->container->usuarioDAO->getByMatriculaNomeARRAY($pesquisa);
        }
        else {
            $this->container->view['users'] = $this->container->usuarioDAO->getAllARRAY();
        }

        return $this->container->view->render($response, 'adminListUsers.tpl');
    }


    public function visualizarAmigoAction(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getByIdFetched($args['id']);

        $user = $request->getAttribute('user');
        $this->container->view['notificacoes'] =  $this->container->usuarioDAO->getConvitesPendentes($user->getId());

        if(!$usuario) {
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        CalculateAttributes::calculateUsuarioStatistics($usuario);

        $medalhasUsuario = $this->container->usuarioDAO->getMedalsByIdFetched($usuario->getId());

        $this->container->view['medalhas'] = $medalhasUsuario;
        $this->container->view['usuario'] = $usuario;
        $this->container->view['todasMedalhas'] =  $this->container->usuarioDAO->getTodasMedalhas();;
        $this->container->view['top10Ira'] = $this->container->usuarioDAO->getTop10IraTotal();
        $this->container->view['top10IraPeriodoPassado'] = $this->container->usuarioDAO->getTop10IraPeriodo();
        $this->container->view['naoBarraPesquisa'] = true;

        return $this->container->view->render($response, 'home.tpl');
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
        $allUsers = $this->container->usuarioDAO->getUsersNotasByGrade(12018);
        $disciplinas = $this->container->usuarioDAO->getDisciplinasByGradePeriodo(12018, 1);

        //$allGrades = $this->container->usuarioDAO->getUsersNotasByGrade('12018');

        $this->container->view['usuariosFull'] = $allUsers;
        $this->container->view['disciplinas'] = $disciplinas;
        //$this->container->view['gradesFull'] = $allGrades;

        return $this->container->view->render($response, 'checkPeriodos.tpl');
    }

    public function informacoesPessoaisAction(Request $request, Response $response, $args)
    {
        $user = $request->getAttribute('user');
        $usuario = $this->container->usuarioDAO->getByIdFetched($user->getId());
        $this->container->view['notificacoes'] =  $this->container->usuarioDAO->getConvitesPendentes($user->getId());

        try {
            if ($request->isPost()) {
                $email = $request->getParsedBodyParam('email');
                $facebook = $request->getParsedBodyParam('facebook');
                $instagram = $request->getParsedBodyParam('instagram');
                $linkedin = $request->getParsedBodyParam('linkedin');
                $lattes = $request->getParsedBodyParam('lattes');
                $sobreMim = $request->getParsedBodyParam('sobre_mim');
                $nomeReal = $request->getParsedBodyParam('nome_real');

                if($nomeReal == 'on')
                    $usuario->setNomeReal(0);
                else
                    $usuario->setNomeReal(1);

                $usuario->setEmail($email);

                $redesComErro = $this->getRedesComErro($facebook, $instagram, $linkedin, $lattes);

                if(in_array("Facebook", $redesComErro))
                    $usuario->setFacebook(null);
                else
                    $usuario->setFacebook($facebook);

                if(in_array("Instagram", $redesComErro))
                    $usuario->setInstagram(null);
                else
                    $usuario->setInstagram($instagram);

                if(in_array("Linkedin", $redesComErro))
                    $usuario->setLinkedin(null);
                else
                    $usuario->setLinkedin($linkedin);

                if(in_array("Lattes", $redesComErro))
                    $usuario->setLattes(null);
                else
                    $usuario->setLattes($lattes);


                $this->container->view['errors'] = $redesComErro;


                $usuario->setSobremim($sobreMim);

                $this->container->usuarioDAO->persist($usuario);
                $this->container->usuarioDAO->flush(); //Commit the transaction
                $this->container->view['success'] = "Informações atualizadas com sucesso";
            }
        }
        catch (\Exception $e){
            $this->container->view['errors'] = $e->getMessage();
        }

        $this->container->view['usuario'] = $usuario;

        if($usuario->getNomeReal())
            $this->container->view['checked'] = "";
        else
            $this->container->view['checked'] = "checked";


        return $this->container->view->render($response, 'informacoesPessoais.tpl');
    }

    public function getRedesComErro($face = null, $insta = null, $linkedin = null, $lattes = null){

        $redesComErro = [];

        if($face != null && strpos($face, "facebook.com") === false){
            $redesComErro[] = 'Facebook';
        }

        if($insta != null && strpos($insta, "instagram.com") === false){
            $redesComErro[] = 'Instagram';
        }

        if($linkedin != null && strpos($linkedin, "linkedin.com") === false){
            $redesComErro[] = 'Linkedin';
        }

        if($lattes != null && strpos($lattes, "lattes.com") === false){
            $redesComErro[] = 'Lattes';

        }

        return $redesComErro;
    }

    public function periodMedalsVerification($grade, $periodo){
        $users = $this->container->usuarioDAO->getUsersNotasByGrade($grade);
        $disciplinas = $this->container->usuarioDAO->getDisciplinasByGradePeriodo($grade, $periodo);
        $cont = 0;
        unset($usrs);
        $usrs = array();
        foreach ($users as $user){
            $user_notas = $user->getNotas();
            foreach ($disciplinas as $disciplina){
                foreach ($user_notas as $un){
                    if ($disciplina->getCodigo() == $un->getDisciplina()->getCodigo())
                        $cont++;
                    else if ($un->getDisciplina()->getCodigo() == $disciplina->getCodigo()."E")
                        $cont++;
                }
            }
            if(sizeof($disciplinas) > 0){
                if ($cont == sizeof($disciplinas)){
                    array_push($usrs, $user);
                }
                $cont = 0;
            }
        }
        return $usrs;
    }

    public function conviteAmizadeAction(Request $request, Response $response, $args){
        $this->container->usuarioDAO->setConviteAmizade($args['id-remetente'], $args['id-destinatario']);

        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function aceitarConviteAction(Request $request, Response $response, $args){
        $this->container->usuarioDAO->aceitarConvite($args['id-remetente'], $args['id-destinatario']);

        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function listarAmigosAction(Request $request, Response $response, $args){

        $amigos = $this->container->usuarioDAO->getAmigos($args['id']);
        $user = $request->getAttribute('user');


        $medalhasAmigo = [];
        foreach ($amigos as $amigo) {
            $medalhasAmigo[] = $this->container->usuarioDAO->getMedalsByIdFetched($amigo['id']);
        }



        $this->container->view['medalhas'] = $medalhasAmigo;
        $this->container->view['amigos']  = $amigos;
        $this->container->view['notificacoes'] =  $this->container->usuarioDAO->getConvitesPendentes($user->getId());

        return $this->container->view->render($response, 'listaAmigos.tpl');
    }

    public function assignMedalsAction(Request $request, Response $response, $args){
        $userId = $_SESSION['id'];

        $this->container->medalhaUsuarioDAO->truncateTable();

        for($i = 1; $i <= 9; $i++){
            $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, $i), $i, 12009);
            $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, $i), $i, 12014);
            $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, $i), $i, 12018);
        }

        $this->container->usuarioDAO->setByIRA($this->container->usuarioDAO->getByIRA(60, 70), 60);
        $this->container->usuarioDAO->setByIRA($this->container->usuarioDAO->getByIRA(70, 80), 70);
        $this->container->usuarioDAO->setByIRA($this->container->usuarioDAO->getByIRA(80, 100), 80);

        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(2, 3, 12009), 2, 12009);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(3, 4, 12009), 3, 12009);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(4, 5, 12009), 4, 12009);

        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(2, 3, 12014), 2, 12014);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(3, 4, 12014), 3, 12014);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(4, 5, 12014), 4, 12014);

        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(2, 3, 12018), 2, 12018);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(3, 4, 12018), 3, 12018);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(4, 5, 12018), 4, 12018);

        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(1, 2, 12009), 1, 12009);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(2, 3, 12009), 2, 12009);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(3, 4, 12009), 3, 12009);

        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(1, 2, 12014), 1, 12014);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(2, 3, 12014), 2, 12014);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(3, 4, 12014), 3, 12014);

        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(1, 2, 12018), 1, 12018);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(2, 3, 12018), 2, 12018);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(3, 4, 12018), 3, 12018);

        //ficou um pouco confuso, mas o get recebe o tipo do certificado (da model 'Certificado.php') e o set recebe o numero da primeira medalha (da tabela 'medalha')
        $this->container->usuarioDAO->setByNumMedalha($this->container->usuarioDAO->getByTipoCertificado(18, $userId), 22);
        $this->container->usuarioDAO->setByNumMedalha($this->container->usuarioDAO->getByTipoCertificado(19, $userId), 30);
        $this->container->usuarioDAO->setByNumMedalha($this->container->usuarioDAO->getByTipoCertificado(20, $userId), 26);
        $this->container->usuarioDAO->setByNumMedalha($this->container->usuarioDAO->getByTipoCertificado(11, $userId), 36, 1);

        $this->container->usuarioDAO->setTurista($userId);
        $this->container->usuarioDAO->setEstagio($userId);

        return $this->container->view->render($response, 'assignMedals.tpl');
        //return $this->container->view->render($response, 'checkPeriodos.tpl');
    }

}

