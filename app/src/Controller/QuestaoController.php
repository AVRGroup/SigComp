<?php
namespace App\Controller;
require __DIR__ . '/../../../vendor/autoload.php';
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Questao;

class QuestaoController
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
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario(0);
        $this->container->view['questoes'] = $questoes;

        return $this->container->view->render($response, 'questoes.tpl');
    }

    public function storeQuestao(Request $request, Response $response, $args)
    {
        if($request->getParsedBodyParam("novaQuestao") !== null)
        {
            $enunciado = $request->getParsedBodyParam("novaQuestao");
        }
        if($request->getParsedBodyParam("numeroQuestao") !== null)
        {
            $numero = $request->getParsedBodyParam("numeroQuestao");
        }

        $this->container->questaoDAO->garavaQuestao($enunciado, $numero);

        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $this->container->view['usuario'] = $usuario;
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario(0);
        $this->container->view['questoes'] = $questoes;
        return $this->container->view->render($response, 'questoes.tpl');
    }
}