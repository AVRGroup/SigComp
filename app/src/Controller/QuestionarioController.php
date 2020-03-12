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
        $base_url = $request->getParsedBodyParam("base_url");
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
            $questionario = $this->container->questionarioDAO->getById($id_questionario);
            $this->container->view['questionario'] = $questionario;
            $this->container->view['questoes'] = $questoes;
            $this->container->view['versao'] = $versao;   
            $this->container->view['categoria'] = $categoria;
            $ultimaVersao = $this->container->questionarioDAO->getUltimaVersao();
            $this->container->view['ultima_versao'] = $ultimaVersao;
            return $this->container->view->render($response, 'edicaoQuestoes.tpl'); 
            #header("Location: $base_url/edicaoQuestoes.tpl");

        }else{
            $usuario = $this->container->usuarioDAO->getUsuarioLogado();
            $this->container->view['usuario'] = $usuario;
            $questionarios = $this->container->questionarioDAO->getAll();
            $this->container->view['questionarios'] = $questionarios;
            $this->container->view['incompleto'] = "Selecione um filtro!";
            $this->container->view->render($response, 'edicaoQuestionario.tpl');
            #header("Location: $base_url/edicaoQuestionario.tpl");
        }

    }
    
    public function storeQuestoes(Request $request, Response $response, $args)
    {
        $base_url = $request->getParsedBodyParam("base_url");
        $versao = $request->getParsedBodyParam("versao");
        $categoria = $request->getParsedBodyParam("categoria");

        if($categoria == "3"){
            $questoes = $this->container->questaoDAO->getAllByVersaoQuestionario($versao);
        }
        else{
            $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versao, $categoria);
        }

        #Loop que checa as edições
        $editou = 0;
        foreach($questoes as $questao){
            $id_questao = $questao->getId();
            $novo_enunciado = $request->getParsedBodyParam("edita_$id_questao");
            #compara o enunciado entre a nova questão e a original. Se houver mudanças, persiste
            if($novo_enunciado !== $questao->getEnunciado()){
                $this->container->questaoDAO->setEnunciado($id_questao, $novo_enunciado);
                $editou ++;
            }
        }

        #Loop que checa as exclusões
        $excluiu = 0;
        foreach($questoes as $questao){
            $id_questao = $questao->getId();
            if (isset($_POST["exclui_$id_questao"])) {
                $this->excluiQuestao($request, $response, $args, $id_questao);
                unset($_POST["exclui_$id_questao"]);
                $excluiu ++;
            }
        }

        if($editou || $excluiu){
            //salvar o novo questionário
        }

        if(!$excluiu){
            $this->listaQuestoes($request, $response, $args);
        }
    }

    public function excluiQuestao(Request $request, Response $response, $args, $id_questao)
    {
        $questao = $this->container->questaoDAO->getById($id_questao);
        if($questao !== null){
            $this->container->questaoDAO->dropById($id_questao);
        }

        $this->listaQuestoes($request, $response, $args);
    }
}