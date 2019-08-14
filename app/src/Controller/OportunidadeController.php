<?php

namespace App\Controller;

use App\Model\Oportunidade;
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
        $oportunidades = $this->container->oportunidadeDAO->getAll();

        $this->container->view['oportunidades'] = $oportunidades;

        return $this->container->view->render($response, 'verOportunidades.tpl');
    }

    public function formCadastrarOportunidade(Request $request, Response $response, $args)
    {
        $disciplinas = $this->container->disciplinaDAO->getAll();

        $this->container->view['disciplinas'] = $disciplinas;

        return $this->container->view->render($response, 'novaOportunidade.tpl');
    }


    public function criarOportunidade(Request $request, Response $response, $args)
    {

        $tipo = $request->getParsedBodyParam('tipo_oportunidade');
        $numeroVagas = $request->getParsedBodyParam('numero_vagas');
        $professor = $request->getParsedBodyParam('nome_professor');
        $descricao = $request->getParsedBodyParam('descricao');
        $validade = new \DateTime($request->getParsedBodyParam('validade'));
        $preRequisitos = $request->getParsedBodyParam('pre_requisitos');
        $arquivo = $request->getUploadedFiles()['pdf_oportunidade'];

        $temRemuneracao = $request->getParsedBodyParam('tem_remuneracao');
        $valorRemuneracao = $temRemuneracao == 'voluntario' ? 0 : $request->getParsedBodyParam('valor_remuneracao');

        $oportunidade = new Oportunidade();
        $oportunidade->setTipo($tipo);
        $oportunidade->setDescricao($descricao);
        $oportunidade->setValidade($validade);
        $oportunidade->setProfessor($professor);
        $oportunidade->setQuantidadeVagas($numeroVagas);
        $oportunidade->setRemuneracao($valorRemuneracao);
        $this->setArquivo($oportunidade, $arquivo);

        if(isset($preRequisitos) && sizeof($preRequisitos >= 1)) {
            foreach ($preRequisitos as $preRequisito) {
                $disciplina = $this->container->disciplinaDAO->getById($preRequisito);
                $oportunidade->addDisciplina($disciplina);
            }
        }

        try {
            $this->container->oportunidadeDAO->save($oportunidade);
            $this->container->view['success'] = true;
        } catch (Exception $e) {
            $this->container->view['error'] = $e->getMessage();
        }


        return $response->withRedirect($this->container->router->pathFor('cadastrarOportunidade'));
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

}

