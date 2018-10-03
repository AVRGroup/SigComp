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
        $this->container->view['usuario'] = $usuario;
        $this->container->view['top10Ira'] = $this->container->usuarioDAO->getTop10IraTotal();
        $this->container->view['top10IraPeriodoPassado'] = $this->container->usuarioDAO->getTop10IraPeriodo();

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

        $this->container->view['usuario'] = $usuario;

        return $this->container->view->render($response, 'informacoesPessoais.tpl');
    }

    public function atualizaInformacoesPessoaisAction(Request $request, Response $response, $args){
        $nickname = $request->getAttribute('nickname');
        var_dump($request);
        $this->container->view['nickname'] = $nickname;

        return $this->container->view->render($response, 'teste.tpl');
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

    public function assignMedalsAction(Request $request, Response $response, $args){

        $this->container->medalhaUsuarioDAO->truncateTable();

        for($i = 1; $i <= 9; $i++){
            $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, $i), $i, 12009);
            $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, $i), $i, 12014);
            $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, $i), $i, 12018);
        }
        /*$this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, 1), 1);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, 2), 2);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, 3), 3);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, 4), 4);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, 5), 5);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, 6), 6);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, 7), 7);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, 8), 8);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12009, 9), 9);

        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, 1), 1);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, 2), 2);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, 3), 3);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, 4), 4);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, 5), 5);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, 6), 6);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, 7), 7);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, 8), 8);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12014, 9), 9);

        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, 1), 1);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, 2), 2);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, 3), 3);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, 4), 4);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, 5), 5);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, 6), 6);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, 7), 7);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, 8), 8);
        $this->container->usuarioDAO->setPeriodo($this->periodMedalsVerification(12018, 9), 9);*/

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

        return $this->container->view->render($response, 'assignMedals.tpl');
        //return $this->container->view->render($response, 'checkPeriodos.tpl');
    }
}

