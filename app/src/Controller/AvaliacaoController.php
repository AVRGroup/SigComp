<?php
namespace App\Controller;
require __DIR__ . '/../../../vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Usuario;
use App\Model\Questao;

class AvaliacaoController
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
        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
        return $this->container->view->render($response, 'avaliacoes.tpl');
    }
    
    public function page1(Request $request, Response $response, $args)
    {
        $disciplina = $request->getParam('disciplina');
        $this->container->view['disciplina'] = $disciplina;
        $codigo = $request->getParam('codigo');
        $this->container->view['codigo'] = $codigo;
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario(0);
        $this->container->view['questoes'] = $questoes;
        return $this->container->view->render($response, 'avaliacaoPage1.tpl');
    }

    /*
    public function page2(Request $request, Response $response, $args)
    {
        $parametro = $request->getParam('disciplina');
        $this->container->view['parametro'] = $parametro;
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario(2);
        $this->container->view['questoes'] = $questoes;
        return $this->container->view->render($response, 'avaliacaoPage2.tpl');
    }

    public function page3(Request $request, Response $response, $args)
    {
        $parametro = $request->getParam('disciplina');
        $this->container->view['parametro'] = $parametro;
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario(1);
        $this->container->view['questoes'] = $questoes;
        return $this->container->view->render($response, 'avaliacaoPage3.tpl');
    }*/

    public function getPeriodoAtual()
    {
        $ultimaCarga = explode("-", $this->container->usuarioDAO->getPeriodoCorrente());
        $ano = $ultimaCarga[0];
        $mes = intval($ultimaCarga[1]);

        if($mes > 6) {
            $periodo = $ano . 3;
        }
        else {
            $periodo = $ano . 1;
        }

        return $periodo;
    }

    public function getPeriodoPassado()
    {
        $periodoAtual = $this->getPeriodoAtual();
        $semestre = intval($periodoAtual[4]);
        $ano = substr($periodoAtual, 0, 4);

        if($semestre == 1) {
            $anoAnterior = date('Y', strtotime($ano . " -1 year"));
            $periodoAnterior = $anoAnterior . 3;
        }
        else {
            $periodoAnterior = $ano . 1;
        }

        return intval($periodoAnterior);
    }

    public function storePage1(Request $request, Response $response, $args)
    {
        $disciplina = $request->getParam('disciplina');
        $this->container->view['disciplina'] = $disciplina;
        $codigo = $request->getParam('codigo');
        $this->container->view['codigo'] = $codigo;
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario(0);
        $this->container->view['questoes'] = $questoes;


        $questao1 = $request->getParsedBodyParam('CustomRadio01');

        if(isset($questao1)){

                return $this->container->view->render($response, 'avaliacaoPage1.tpl');

        }   else {
            
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage1.tpl');
        }
    }

    public function storePage2(Request $request, Response $response, $args)
    {
        $disciplina = $request->getParam('disciplina');
        $this->container->view['disciplina'] = $disciplina;
        $codigo = $request->getParam('codigo');
        $this->container->view['codigo'] = $codigo;
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario(2);
        $this->container->view['questoes'] = $questoes;

        $questao1 = $request->getParsedBodyParam('CustomRadio02');

        if(isset($questao1)){

            return $this->container->view->render($response, 'avaliacaoPage2.tpl');

        }   else {
            
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage2.tpl');
        }
    }

    public function storePage3(Request $request, Response $response, $args)
    {
        $disciplina = $request->getParam('disciplina');
        $this->container->view['disciplina'] = $disciplina;
        $codigo = $request->getParam('codigo');
        $this->container->view['codigo'] = $codigo;
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario(1);
        $this->container->view['questoes'] = $questoes;

        $questao1 = $request->getParsedBodyParam('CustomRadio03');

        if(isset($questao1)){

            return $this->container->view->render($response, 'avaliacaoPage3.tpl');

        }   else {
            
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage3.tpl');     
        }
    }

    public function Enviar(Request $request, Response $response, $args)
    {
        $questao1 = $request->getParsedBodyParam('CustomRadio03');

        if(isset($questao1)){

            //Aqui a função vai enviar os dados pro banco 

        }   else {
            
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage3.tpl');     
        }

    }
}