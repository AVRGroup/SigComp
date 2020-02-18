<?php
namespace App\Controller;
require __DIR__ . '/../../../vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Usuario;
use App\Model\Questao;
use App\Model\Questionario;

class QuestionarioController
{
    private $container;
    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $this->container->view['usuario'] = $usuario;
        $questionarios = $this->container->questionarioDAO->getAll();
        $this->container->view['questionarios'] = $questionarios;

        return $this->container->view->render($response, 'edicaoQuestionario.tpl');
    }

    public function listaQuestoes(Request $request, Response $response, $args)
    {
        $filtro = 0;
        if($request->getParsedBodyParam("filtro_versao") !== null){
            $versao = $request->getParsedBodyParam("filtro_versao");
            if($request->getParsedBodyParam("filtro_categoria") !== null){
                $categoria = $request->getParsedBodyParam("filtro_categoria");
                $filtro = 1;
            }
        }
        
        if($filtro == 1){
            $id_questionario = $this->container->questionarioDAO->getIdByVersao($versao);
            if($categoria == "3"){
                $questoes = $this->container->questaoDAO->getAllByVersaoQuestionario($versao);
            }
            else{
                $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versao, $categoria);
            }
            $this->container->view['questoes'] = $questoes;
            $this->container->view['versao'] = $versao;   
            $this->container->view['categoria'] = $categoria;
            $ultimaVersao = $this->container->questionarioDAO->getUltimaVersao();
            $this->container->view['ultima_versao'] = $ultimaVersao;
            return $this->container->view->render($response, 'edicaoQuestoes.tpl'); 

        }else{
            $usuario = $this->container->usuarioDAO->getUsuarioLogado();
            $this->container->view['usuario'] = $usuario;
            $questionarios = $this->container->questionarioDAO->getAll();
            $this->container->view['questionarios'] = $questionarios;
            $this->container->view['incompleto'] = "Selecione um filtro!";
            return $this->container->view->render($response, 'edicaoQuestionario.tpl');
        }
    }
}