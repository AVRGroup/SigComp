<?php


namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class GrupoController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $curso = $usuario->getCurso() ?: "35A";

        $codigoGrade = $request->getQueryParam('grade');

        if(isset($grade)) {
            $grade = $this->container->gradeDAO->getByCodigo($codigoGrade);
        } else {
            $grade = $this->container->gradeDAO->getFirstByCurso($curso);
        }

        $disciplinas = $this->container->disciplinaDAO->getByGrade($grade->getId());

        $todasGrades = $this->container->gradeDAO->getAllByCurso($curso);

        $this->container->view['disciplinas'] = $disciplinas;
        $this->container->view['$todasGrades'] = $todasGrades;

        return $this->container->view->render($response, 'verGrade.tpl');
    }
}