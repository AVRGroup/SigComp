<?php

namespace App\Controller;

use App\Model\Oportunidade;
use Doctrine\Instantiator\Exception\ExceptionInterface;
use Exception;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;

class OportunidadeController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }


    public function verOportunidades(Request $request, Response $response, $args)
    {
        $idUsuario = $_SESSION['id'];
        $usuario = $this->container->usuarioDAO->getById($idUsuario);

        $this->container->view['usuario'] = $usuario;

        $disciplinasAprovadas = $this->container->usuarioDAO->getDisciplinasAprovadasById($usuario->getId());
        $oportunidades = $this->container->oportunidadeDAO->getAll();

        $this->container->view['oportunidades'] = $oportunidades;
        $this->container->view['disciplinasAprovadas'] = $disciplinasAprovadas;

        $periodoCorrente = $this->container->usuarioDAO->getPeriodoCorrente();
        $this->container->view['periodo'] = $this->container->usuarioDAO->getUsersPeriodoAtual($idUsuario, $periodoCorrente);

        return $this->container->view->render($response, 'verOportunidades.tpl');
    }

    public function mostrarOportunidade(Request $request, Response $response, $args)
    {
        $oportunidade = $this->container->oportunidadeDAO->getById($args['id']);
        $disciplinasAprovadas = $this->container->usuarioDAO->getDisciplinasAprovadasById($_SESSION['id']);

        $preRequisitos = $oportunidade->getDisciplinas();
        $this->container->view['oportunidade'] = $oportunidade;

        $idDisciplinas = [];
        foreach ($disciplinasAprovadas as $disciplinasAprovada) {
            array_push($idDisciplinas, intval($disciplinasAprovada['disciplina']));
        }


        $this->container->view['disciplinasAprovadas'] = $idDisciplinas;

        $idPreRequisitos = [];
        foreach ($preRequisitos as $disciplina) {
            array_push($idPreRequisitos, intval($disciplina->getId()));
        }
        $this->container->view['preRequisitos'] = $idPreRequisitos;


        $this->container->view->render($response, 'oportunidadeIndividual.tpl');
    }

    public function formCadastrarOportunidade(Request $request, Response $response, $args)
    {
        $disciplinas = $this->container->disciplinaDAO->getAll();

        $this->container->view['disciplinas'] = $disciplinas;

        return $this->container->view->render($response, 'novaOportunidade.tpl');
    }


    public function criarOportunidade(Request $request, Response $response, $args)
    {
        $erros = $this->validaFormulario($request);
        $idUsuario = $_SESSION['id'];

        if(sizeof($erros) > 0){
            $this->container->view['error'] = $erros;
            return $response->withRedirect($this->container->router->pathFor('verOportunidades'));
        }

        $tipo = $request->getParsedBodyParam('tipo_oportunidade');

        if($request->getParsedBodyParam('informar-vagas') == -1) {
            $numeroVagas = -1;
        } else {
            $numeroVagas = $request->getParsedBodyParam('numero_vagas');
        }

        $professor = $request->getParsedBodyParam('nome_professor');
        $descricao = $request->getParsedBodyParam('descricao');
        $validade = new \DateTime($request->getParsedBodyParam('validade'));
        $preRequisitos = $request->getParsedBodyParam('pre_requisitos');
        $pdf = $request->getUploadedFiles()['pdf_oportunidade'];
        $imagem = $request->getUploadedFiles()['imagem_oportunidade'];

        $temRemuneracao = $request->getParsedBodyParam('tem_remuneracao');
        if($temRemuneracao == "nao_informado") {
            $valorRemuneracao = -1;
        } elseif($temRemuneracao == 'voluntario') {
            $valorRemuneracao = 0;
        } else {
            $valorRemuneracao = $request->getParsedBodyParam('valor_remuneracao');
        }

        $periodoMinimo = intval($request->getParsedBodyParam('periodo_minimo'));
        $periodoMaximo = intval($request->getParsedBodyParam('periodo_maximo'));

        $oportunidade = new Oportunidade();
        $oportunidade->setTipo($tipo);
        $oportunidade->setDescricao($descricao);
        $oportunidade->setValidade($validade);
        $oportunidade->setProfessor($professor);
        $oportunidade->setQuantidadeVagas($numeroVagas);
        $oportunidade->setRemuneracao($valorRemuneracao);
        $oportunidade->setCriadoEm(new \DateTime());
        $oportunidade->setPeriodoMinimo($periodoMinimo);
        $oportunidade->setPeriodoMaximo($periodoMaximo);

        if($pdf->getSize() > 0) {
            $this->setArquivo($oportunidade, $pdf);
        }

        if($imagem->getSize() > 0) {
            $this->setArquivoImagem($oportunidade, $imagem);
        }


        if(isset($preRequisitos) && sizeof($preRequisitos >= 1)) {
            foreach ($preRequisitos as $preRequisito) {
                $disciplina = $this->container->disciplinaDAO->getById($preRequisito);
                $oportunidade->addDisciplina($disciplina);
            }
        }

        try {
            $this->container->oportunidadeDAO->save($oportunidade);
            $this->container->view['success'] = "Oportunidade cadastrada com sucesso!";
        } catch (Exception $e) {
            $this->container->view['error'] = $e->getMessage();
        }

        return $response->withRedirect($this->container->router->pathFor('verOportunidades'));
    }

    public function validaFormulario(Request $request)
    {
        $erros = [];

        $periodoMinimo = intval($request->getParsedBodyParam('periodo_minimo'));
        $periodoMaximo = intval($request->getParsedBodyParam('periodo_maximo'));

        if($periodoMaximo < $periodoMinimo) {
            $erros['periodo'] = "Perído máximo deve ser maior que o período mínimo";
        }

        return $erros;
    }

    public function setArquivo($oportunidade, $arquivo)
    {
        $extension = mb_strtolower(pathinfo($arquivo->getClientFilename(), PATHINFO_EXTENSION));
        $oportunidade->setExtensao($extension);

        do {
            $uuid4 = Uuid::uuid4();
            $oportunidade->setArquivo($uuid4->toString() . '.' . $extension);
        } while (file_exists($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $oportunidade->getArquivo()));

        $arquivo->moveTo($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $oportunidade->getArquivo());
    }

    public function setArquivoImagem($oportunidade, $arquivo)
    {
        $extension = mb_strtolower(pathinfo($arquivo->getClientFilename(), PATHINFO_EXTENSION));
        $oportunidade->setExtensaoImagem($extension);

        do {
            $uuid4 = Uuid::uuid4();
            $oportunidade->setArquivoImagem($uuid4->toString() . '.' . $extension);
        } while (file_exists($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $oportunidade->getArquivoImagem()));

        $arquivo->moveTo($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $oportunidade->getArquivoImagem());
    }

    public function editOportunidade(Request $request, Response $response, $args)
    {
        $oportunidade = $this->container->oportunidadeDAO->getById($args['id']);

        $tipo = $request->getParsedBodyParam('tipo_oportunidade');

        if($request->getParsedBodyParam('informar-vagas') == -1) {
            $numeroVagas = -1;
        } else {
            $numeroVagas = $request->getParsedBodyParam('numero_vagas');
        }

        $professor = $request->getParsedBodyParam('nome_professor');
        $descricao = $request->getParsedBodyParam('descricao');
        $validade = new \DateTime($request->getParsedBodyParam('validade'));

        $temRemuneracao = $request->getParsedBodyParam('tem_remuneracao');
        if($temRemuneracao == "nao_informado") {
            $valorRemuneracao = -1;
        } elseif($temRemuneracao == 'voluntario') {
            $valorRemuneracao = 0;
        } else {
            $valorRemuneracao = $request->getParsedBodyParam('valor_remuneracao');
        }

        $periodoMinimo = intval($request->getParsedBodyParam('periodo_minimo'));
        $periodoMaximo = intval($request->getParsedBodyParam('periodo_maximo'));

        $oportunidade->setTipo($tipo);
        $oportunidade->setDescricao($descricao);
        $oportunidade->setValidade($validade);
        $oportunidade->setProfessor($professor);
        $oportunidade->setQuantidadeVagas($numeroVagas);
        $oportunidade->setRemuneracao($valorRemuneracao);
        $oportunidade->setCriadoEm(new \DateTime());
        $oportunidade->setPeriodoMinimo($periodoMinimo);
        $oportunidade->setPeriodoMaximo($periodoMaximo);

        try {
            $this->container->oportunidadeDAO->save($oportunidade);
        } catch (Exception $e) {
            die(var_dump($e->getMessage()));
        }

        return $response->withRedirect($this->container->router->pathFor('verOportunidades'));
    }


    public function formEditOportunidade(Request $request, Response $response, $args)
    {
        $oportunidade = $this->container->oportunidadeDAO->getById($args['id']);
        $this->container->view['oportunidade'] = $oportunidade;

        return $this->container->view->render($response, 'editarOportunidade.tpl');
    }

    public function deleteOportunidade(Request $request, Response $response, $args)
    {
        $oportunidade = $this->container->oportunidadeDAO->getById($args['id']);

        try {
            $this->container->oportunidadeDAO->delete($oportunidade);
        } catch (Exception $e) {
            $this->container->view['error'] = $e->getMessage();
        }

        return $response->withRedirect($this->container->router->pathFor('verOportunidades'));
    }

}

