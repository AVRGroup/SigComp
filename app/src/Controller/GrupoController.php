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
        $gradesExists = array();

        $codigoGrade = $request->getQueryParam('grade');
        $codigoCurso = $request->getQueryParam('curso');

        if(isset($codigoGrade)) {
            $grade = $this->container->gradeDAO->getByCodigoCurso($codigoGrade, $codigoCurso);
        } else {
            $grade = $this->container->gradeDAO->getFirstByCurso("35A");
        }

        if(!isset($grade)) {
            return $response->withRedirect($this->container->router->pathFor('adminDashboard'));
        }

        $disciplinas = $this->container->disciplinaDAO->getByGrade($grade->getId());
        $todasGrades = $this->container->gradeDAO->getAll();

        #Verifica quais grades possuem grupo
        foreach( $todasGrades as $tg ){
            if( $this->container->grupoDAO->existsCourseWithGroup($tg->getCurso()) == true ){
               $gradesExists[] = $tg;
            }
        }

        if(isset($codigoCurso)){
            $grupos = $this->container->grupoDAO->getAllByCurso($codigoCurso);
        } else {
            $grupos = $this->container->grupoDAO->getAllByCurso("35A");
        }

        $this->container->view['disciplinas'] = $disciplinas;
        $this->container->view['todasGrades'] = $gradesExists;
        $this->container->view['grupos'] = $grupos;
        $this->container->view['gradeSelecionada'] = $grade;
        $this->container->view['container'] = $this->container;
        $this->container->view['curso'] = $codigoCurso;

        return $this->container->view->render($response, 'verGrupo.tpl');
    }

    public function create(Request $request, Response $response, $args)
    {
        $arrayCursos = array();
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();

        $grupos = $this->container->grupoDAO->getAll();

        $cursos = $this->container->gradeDAO->getCursos();
        
        foreach( $cursos as $cur ){
            if( $cur['curso'] !== null ){
                $arrayCursos[] = $cur['curso'];
            }
        }

        $cursoSelecionado = $request->getQueryParam('cursoSelecionado') ?: '35A';

        $this->container->view['cursos'] = $arrayCursos;
        $this->container->view['cursoSelecionado'] = $cursoSelecionado;
        $this->container->view['grupos'] = $grupos;

        return $this->container->view->render($response, 'novoGrupo.tpl');
    }

    public function store(Request $request, Response $response, $args)
    {
        $nome = $request->getParsedBodyParam('nome');
        if( $nome == '' ){
            $this->container->view['error'] = "O nome do grupo não pode ficar vazio!";
            return $this->create($request, $response, $args);
        } 
        
        $curso = $_POST['dropDown'];

        $grupo = new Grupo();
        $grupo->setNome($nome);
        $grupo->setCurso($curso);

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

        $grupos = $this->container->grupoDAO->getAll();

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

    public function changeNameForm(Request $request, Response $response, $args)
    {
        $grupoId = $request->getAttribute('grupo');

        $grupo = $this->container->grupoDAO->getGrupoById($grupoId)[0];

        $this->container->view['grupo'] = $grupo;

        return $this->container->view->render($response, 'changeNameForm.tpl');
    }

    public function changeNameAction(Request $request, Response $response, $args)
    {
        $grupoId = $request->getAttribute('grupo');

        $nome = $request->getParsedBodyParam('nome');

        $grupo = $this->container->grupoDAO->getGrupoById($grupoId)[0];
        $ordem = $grupo->getOrdem();

        $nome = $ordem . '-' . $nome;

        $grupo->setNome($nome);
        $this->container->grupoDAO->save($grupo);


        return $response->withRedirect($this->container->router->pathFor('editGrupo'));
    }

    public function destroy(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();

        $grupoId = $request->getAttribute('grupo');
        $grupo = $this->container->grupoDAO->getGrupoById($grupoId)[0];

        $this->container->grupoDisciplinaCursoDAO->deleteByGrupoCurso($grupoId, $usuario->getCurso());
        
        $this->container->grupoDAO->delete($grupo);

        return $response->withRedirect($this->container->router->pathFor('editGrupo'));
    }
}
