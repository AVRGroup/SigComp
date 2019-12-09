<?php


namespace App\Controller;

use App\Model\Grupo;
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

        if(isset($codigoGrade)) {
            $grade = $this->container->gradeDAO->getByCodigoCurso($codigoGrade, $usuario->getCurso());
        } else {
            $grade = $this->container->gradeDAO->getFirstByCurso($curso);
        }

        $disciplinas = $this->container->disciplinaDAO->getByGrade($grade->getId());

        $todasGrades = $this->container->gradeDAO->getAllByCurso($curso);

        $grupos = $this->container->grupoDAO->getAllByCurso($curso);

        $this->container->view['disciplinas'] = $disciplinas;
        $this->container->view['todasGrades'] = $todasGrades;
        $this->container->view['grupos'] = $grupos;
        $this->container->view['gradeSelecionada'] = $grade;

        return $this->container->view->render($response, 'verGrupo.tpl');
    }

    public function create(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();

        $grupos = $this->container->grupoDAO->getAllByCurso($usuario->getCurso());

        $this->container->view['grupos'] = $grupos;

        return $this->container->view->render($response, 'novoGrupo.tpl');
    }

    public function store(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $nome = $request->getParsedBodyParam('nome');

        $grupo = new Grupo();
        $grupo->setNome($nome);
        $grupo->setCurso($usuario->getCurso());

        $this->container->grupoDAO->save($grupo);

        return $response->withRedirect($this->container->router->pathFor('createGrupo'));
    }
    
    
    public function storeDisciplinaGrupo(Request $request, Response $response, $args)
    {
        $gradeId = $request->getParsedBodyParam('grade-selecionada');

        $disciplinas = $this->container->disciplinaDAO->getByGrade($gradeId);

        foreach ($disciplinas as $disciplina) {
            $grupoId = $request->getParsedBodyParam($disciplina->getCodigo());

            $grupo = $this->container->grupoDAO->getGrupoById($grupoId);

            if(isset($grupo) && sizeof($grupo) > 0) {
                $grupo = $grupo[0];

                $disciplina->setGrupo($grupo);
                $this->container->disciplinaDAO->save($disciplina);
            }
        }

        return $response->withRedirect($this->container->router->pathFor('verGrupo'));
    }


}
