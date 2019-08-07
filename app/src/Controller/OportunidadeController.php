<?php

namespace App\Controller;

use App\Model\Oportunidade;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class OportunidadeController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function formCadastrarOportunidade(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'novaOportunidade.tpl');
    }

    public function criarOportunidade(Request $request, Response $response, $args)
    {

        $tipo = $request->getParsedBodyParam('tipo_oportunidade');
        $numeroVagas = $request->getParsedBodyParam('numero_vagas');
        $professor = $request->getParsedBodyParam('nome_professor');
        $descricao = $request->getParsedBodyParam('descricao');

        $temRemuneracao = $request->getParsedBodyParam('tem_remuneracao');
        $valorRemuneracao = $temRemuneracao == 'voluntario' ? 0 : $request->getParsedBodyParam('valor_remuneracao');

        $oportunidade = new Oportunidade();
        $oportunidade->setTipo($tipo);
        $oportunidade->setDescricao($descricao);
        $oportunidade->setProfessor($professor);
        $oportunidade->setQuantidadeVagas($numeroVagas);
        $oportunidade->setRemuneracao($valorRemuneracao);

        try {
            $this->container->oportunidadeDAO->save($oportunidade);
            $this->container->view['success'] = true;
        } catch (Exception $e) {
            $this->container->view['error'] = $e->getMessage();
        }

        return $this->container->view->render($response, 'novaOportunidade.tpl');
    }

}

