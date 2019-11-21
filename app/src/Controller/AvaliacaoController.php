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
        $questoes2 = $this->container->questaoDAO->getAllByTipoQuestionario(2);
        $this->container->view['questoes2'] = $questoes2;
    }

    public function page3(Request $request, Response $response, $args)
    {
        $questoes3 = $this->container->questaoDAO->getAllByTipoQuestionario(1);
        $this->container->view['questoes3'] = $questoes3;
    }
    */

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
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario(0);
        $this->container->view['questoes'] = $questoes;

        $codigo = $request->getParsedBodyParam("codigo");
        $disciplina = $request->getParsedBodyParam("disciplina");
        $this->container->view['disciplina'] = $disciplina;
        $this->container->view['codigo'] = $codigo;

        //Salvando as respostas no vetor
        $respostas1 = array();
        $i = 1;
        foreach ($questoes as $questao)
        {
            if($request->getParsedBodyParam("customRadio1_$i") !== null)
            {
                $respostas1[] = $request->getParsedBodyParam("customRadio1_$i");
            }
            $i = $i + 1;
        }
        
        /*
        $j = 0;
        foreach ($respostas1 as $r)
        {
            echo "<script>console.log('Debug Objects: " . $respostas1[$j] . "' );</script>";
            $j = $j + 1;
        }
        */

        if(count($respostas1) == count($questoes)){

            $a = array("1","2", "3", "4", "5", "6");
            $this->container->view['a'] = $a;

            $this->container->view['respostas1'] = $respostas1;   
            $questoes2 = $this->container->questaoDAO->getAllByTipoQuestionario(2);
            $this->container->view['questoes2'] = $questoes2;
            return $this->container->view->render($response, 'avaliacaoPage2.tpl');
                

        }   else {
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage1.tpl');
        }
    }

    public function storePage2(Request $request, Response $response, $args)
    {
        $questoes2 = $this->container->questaoDAO->getAllByTipoQuestionario(2);
        $this->container->view['questoes2'] = $questoes2;
        $codigo = $request->getParsedBodyParam("codigo");
        $disciplina = $request->getParsedBodyParam("disciplina");
        $this->container->view['disciplina'] = $disciplina;
        $this->container->view['codigo'] = $codigo;
        $respostas1 = $request->getParsedBodyParam("respostas1");
        $this->container->view['respostas1'] = $respostas1;
        
              
       //Salvando as respostas no vetor
       $respostas2 = array();
       $i = 1;
       foreach ($questoes2 as $questao)
       {
           if($request->getParsedBodyParam("customRadio2_$i") !== null)
           {
               $respostas2[] = $request->getParsedBodyParam("customRadio2_$i");
           }
           $i = $i + 1;
       }

       $respostas1_2 = array_merge($respostas1, $respostas2);
       die(var_dump($respostas1_2));
       
       /*$respostas1_2 = $respostas1 + $respostas2;
       $j = 0;
       foreach($respostas1_2 as $r)
       {
        echo "<script>console.log('Debug Objects: " . $respostas1_2[$j] . "' );</script>";
        $j = $j + 1;
       }*/


        if(count($respostas2) == count($questoes2)){
            $this->container->view['respostas1_2'] = $respostas1_2;
            $questoes3 = $this->container->questaoDAO->getAllByTipoQuestionario(1);
            $this->container->view['questoes3'] = $questoes3;
            return $this->container->view->render($response, 'avaliacaoPage3.tpl');

        }   else {
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage2.tpl');
        }
    }

    public function storePage3(Request $request, Response $response, $args)
    {
        $questoes3 = $this->container->questaoDAO->getAllByTipoQuestionario(1);
        $this->container->view['questoes3'] = $questoes3;
        $codigo = $request->getParsedBodyParam("codigo");
        $disciplina = $request->getParsedBodyParam("disciplina");
        $this->container->view['disciplina'] = $disciplina;
        $this->container->view['codigo'] = $codigo;

        $respostas3 = array();
        $i = 1;
        foreach ($questoes3 as $questao)
        {
            if($request->getParsedBodyParam("customRadio3_$i") !== null)
            {
                $respostas3[] = $request->getParsedBodyParam("customRadio3_$i");
            }
            $i = $i + 1;
        }
 
         if(count($respostas3) == count($questoes3)){
 
             //Enviar
 
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