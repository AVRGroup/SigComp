<?php


namespace App\Controller;

use App\Model\Grupo;
use App\Model\GrupoDisciplinaCurso;
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

        if(!isset($grade)) {
            return $response->withRedirect($this->container->router->pathFor('adminDashboard'));
        }

        $disciplinas = $this->container->disciplinaDAO->getByGrade($grade->getId());

        $todasGrades = $this->container->gradeDAO->getAllByCurso($curso);

        $grupos = $this->container->grupoDAO->getAllByCurso($curso);

        $this->container->view['disciplinas'] = $disciplinas;
        $this->container->view['todasGrades'] = $todasGrades;
        $this->container->view['grupos'] = $grupos;
        $this->container->view['gradeSelecionada'] = $grade;
        $this->container->view['container'] = $this->container;
        $this->container->view['curso'] = $curso;

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
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $curso = $usuario->getCurso();
        $grade = $request->getParsedBodyParam('grade-selecionada');
        $grade = explode("?", $grade)[1];
        $codGrade = explode("=", $grade)[1];

        $grade = $this->container->gradeDAO->getByCodigoCurso($codGrade, $curso);

        $disciplinas = $this->container->disciplinaDAO->getByGrade($grade->getId());


        foreach ($disciplinas as $disciplina) {
            $grupoId = $request->getParsedBodyParam($disciplina->getCodigo());

            if($grupoId) {
                $grupoDisciplina = $this->container->grupoDisciplinaCursoDAO->getByDisciplinaCurso($disciplina->getId(), $curso);

                if(isset($grupoDisciplina)) {
                    $this->container->grupoDisciplinaCursoDAO->delete($grupoDisciplina);
                }

                $grupoDisciplina = new GrupoDisciplinaCurso();
                $grupoDisciplina->setCurso($curso);
                $grupoDisciplina->setGrupo($grupoId);
                $grupoDisciplina->setDisciplina($disciplina->getId());

                try {
                    $this->container->grupoDisciplinaCursoDAO->save($grupoDisciplina);
                } catch (\Exception $e) {
                    die(var_dump($e->getMessage()));
                }
            }
        }

        return $response->withRedirect($this->container->router->pathFor('verGrupo'));
    }

    public function edit(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();

        $grupos = $this->container->grupoDAO->getAllByCurso($usuario->getCurso());

        $this->container->view['grupos'] = $grupos;

        return $this->container->view->render($response, 'editGrupo.tpl');
    }

    public function update(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $grupos = $this->container->grupoDAO->getAllByCurso($usuario->getCurso());

        foreach ($grupos as $grupo) {
            $ordem = $request->getParsedBodyParam("posicao-grupo-". $grupo->getId());
            if(isset($ordem)) {
                $grupo->setNome($ordem . '-' . $grupo->getNome());
                $this->container->grupoDAO->save($grupo);
            }
        }

        return $response->withRedirect($this->container->router->pathFor('verGrupo'));
    }


}
