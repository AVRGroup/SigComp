<?php


namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class GradeController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();

        if (isset($_SESSION['disciplinaAlteradaComSucesso'])) {
            $this->container->view['sucesso'] = true;
        }

        $codigoGrade = $request->getQueryParam('grade');
        $codigoCurso = $request->getQueryParam('curso');

        if(isset($codigoGrade)) {
            $grade = $this->container->gradeDAO->getByCodigoCurso($codigoGrade, $codigoCurso);
        }else {
            $grade = $this->container->gradeDAO->getFirstByCurso("35A");
        }

        if(!isset($grade)) {
            return $response->withRedirect($this->container->router->pathFor('adminDashboard'));
        }

        $disciplinas = $this->container->disciplinaDAO->getByGrade($grade->getId());

        $todasGrades = $this->container->gradeDAO->getAll();

        $this->container->view['disciplinas'] = $disciplinas;
        $this->container->view['todasGrades'] = $todasGrades;
        $this->container->view['gradeSelecionada'] = $grade;
        $this->container->view['container'] = $this->container;

        return $this->container->view->render($response, 'verGrades.tpl');
    }

    public function edit(Request $request, Response $response, $args)
    {
        $disciplinaId = $request->getAttribute('disciplina');
        $disciplina = $this->container->disciplinaDAO->getById($disciplinaId);

        $this->container->view['disciplina'] = $disciplina;

        return $this->container->view->render($response, 'editGrade.tpl');
    }

    public function update(Request $request, Response $response, $args)
    {
        $disciplinaId = $request->getAttribute('disciplina');
        $disciplina = $this->container->disciplinaDAO->getById($disciplinaId);


        $nome = $request->getParsedBodyParam('nome');
        $carga = $request->getParsedBodyParam('carga');
        $codigo = $request->getParsedBodyParam('codigo');

        $disciplina->setNome($nome);
        $disciplina->setCarga($carga);
        $disciplina->setCodigo($codigo);
        try {
            $this->container->disciplinaDAO->save($disciplina);
            $_SESSION['disciplinaAlteradaComSucesso'] = true;
        } catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }

        return $response->withRedirect($this->container->router->pathFor('verGrade'));
    }

}