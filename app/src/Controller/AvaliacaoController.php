<?php
namespace App\Controller;
require __DIR__ . '/../../../vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Usuario;
use App\Model\Questao;
use App\Model\Questionario;
use App\Model\QuestaoQuestionario;
use App\Model\Avaliacao;
use App\Model\Disciplina;
use App\Model\MedalhaUsuario;
use App\Model\RespostaAvaliacao;

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
        $periodoPassado = $this->getPeriodoPassado();
        $disciplinas_avaliadas = $this->container->avaliacaoDAO->getAvaliacoesByAluno($usuario->getId());
        $notas_usuario = $usuario->getNotas();

        #Verificação de atribuição de medalhas 
        $cont = 0;
        foreach ($notas_usuario as $nota){
            if ($nota->getPeriodo() == $periodoPassado){
                $cont = $cont + 1;
            }
        } 
        if ($cont == sizeof($disciplinas_avaliadas)){
            $this->container->view['concluiu'] = "OK";
        }

        $this->container->view['disciplinas_avaliadas'] = $disciplinas_avaliadas;
        $this->container->view['usuario'] = $usuario;
        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
        
        #USAR SOMENTE PRA INICIALIZAR AS QUESTOES NO BANCO COM ACENTO
        //$this->container->questaoDAO->inicializaQuestoes();
        #------------------------------------------------------------
        return $this->container->view->render($response, 'avaliacoes.tpl');
    }
    
    public function page1(Request $request, Response $response, $args)
    {
        //$this->container->questaoDAO->inicializaQuestoes();
        $id_disciplina = $request->getParam('disciplina');
        $disciplina = $this->container->disciplinaDAO->getById($id_disciplina);
        $this->container->view['disciplina'] = $disciplina->getNome();
        $codigo = $disciplina->getCodigo();
        $this->container->view['codigo'] = $codigo;
        $this->container->view['id_disciplina'] = $id_disciplina;
        $versaoAtual = $this->container->questionarioDAO->getUltimaVersao();
        $this->container->view['versaoAtual'] = $versaoAtual;
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versaoAtual, 0);
        $this->container->view['questoes'] = $questoes;
        $this->container->view['questaoQuestionarioDAO'] = $this->container->questaoQuestionarioDAO;

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
        $versaoAtual = $this->container->questionarioDAO->getUltimaVersao();
        $this->container->view['versaoAtual'] = $versaoAtual;
        $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versaoAtual, 0);       
        $this->container->view['questoes'] = $questoes;
        $codigo = $request->getParsedBodyParam("codigo");
        $disciplina = $request->getParsedBodyParam("disciplina");
        $id_disciplina = $request->getParsedBodyParam("id_disciplina");
        
        $this->container->view['disciplina'] = $disciplina;
        $this->container->view['codigo'] = $codigo;
        $this->container->view['id_disciplina'] = $id_disciplina;
        $turma = $this->container->turmaDAO->getByDisciplinaCodigo($id_disciplina, 'A');

        $this->container->view['questaoQuestionarioDAO'] = $this->container->questaoQuestionarioDAO;

        /*
        $pt = $this->container->professorTurmaDAO->getByTurma($turma->getId());
        $p = $pt->getProfessor();
        $professor = $this->container->usuarioDAO->getById($p);
        echo "<script>console.log('Prof: " . $professor . "' );</script>";
        $this->container->view['professor'] = $professor;
        */
        

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
            $this->container->view['respostas1'] = $respostas1;   
            $questoes2 = $this->container->questaoDAO->getAllByTipoQuestionario($versaoAtual, 2);
            $this->container->view['questoes2'] = $questoes2;

            return $this->container->view->render($response, 'avaliacaoPage2.tpl');
                

        }   else {
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";

            return $this->container->view->render($response, 'avaliacaoPage1.tpl');
        }
    }

    public function storePage2(Request $request, Response $response, $args)
    {
        $versaoAtual = $this->container->questionarioDAO->getUltimaVersao();
        $this->container->view['versaoAtual'] = $versaoAtual;
        $questoes2 = $this->container->questaoDAO->getAllByTipoQuestionario($versaoAtual, 2);
        $this->container->view['questoes2'] = $questoes2;
        $codigo = $request->getParsedBodyParam("codigo");
        $disciplina = $request->getParsedBodyParam("disciplina");
        $id_disciplina = $request->getParsedBodyParam("id_disciplina");
        $this->container->view['disciplina'] = $disciplina;
        $this->container->view['codigo'] = $codigo;
        $this->container->view['id_disciplina'] = $id_disciplina;
        $respostas1 = $request->getParsedBodyParam("respostas1");
        $this->container->view['respostas1'] = $respostas1;
        $this->container->view['questaoQuestionarioDAO'] = $this->container->questaoQuestionarioDAO;
              
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
       
       /*$respostas1_2 = $respostas1 + $respostas2;
       $j = 0;
       foreach($respostas1_2 as $r)
       {
        echo "<script>console.log('Debug Objects: " . $respostas1_2[$j] . "' );</script>";
        $j = $j + 1;
       }*/


        if(count($respostas2) == count($questoes2)){
            $this->container->view['respostas1_2'] = $respostas1_2;
            $questoes3 = $this->container->questaoDAO->getAllByTipoQuestionario($versaoAtual, 1);
            $this->container->view['questoes3'] = $questoes3;
            return $this->container->view->render($response, 'avaliacaoPage3.tpl');

        }   else {
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage2.tpl');
        }
    }

    #Store da page que vai apresentar a medalha do usuario que fez as avaliaçoes
    public function storePageMedalhas(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $this->container->view['usuario'] = $usuario;
        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
        $versaoAtual = $this->container->questionarioDAO->getUltimaVersao();
        $this->container->view['versaoAtual'] = $versaoAtual;

        return $this->container->view->render($response, 'avaliacoes.tpl');
    }

    
    public function storePage3(Request $request, Response $response, $args)
    {
        $versaoAtual = $this->container->questionarioDAO->getUltimaVersao();
        $this->container->view['versaoAtual'] = $versaoAtual;
        $questoes3 = $this->container->questaoDAO->getAllByTipoQuestionario($versaoAtual, 1);
        $this->container->view['questoes3'] = $questoes3;
        $codigo = $request->getParsedBodyParam("codigo");
        $disciplina = $request->getParsedBodyParam("disciplina");
        $id_disciplina = $request->getParsedBodyParam("id_disciplina");
        $this->container->view['disciplina'] = $disciplina;
        $this->container->view['codigo'] = $codigo;
        $this->container->view['id_disciplina'] = $id_disciplina;
        $respostas1_2 = $request->getParsedBodyParam("respostas1_2");
        $this->container->view['respostas1_2'] = $respostas1_2;

        $this->container->view['questaoQuestionarioDAO'] = $this->container->questaoQuestionarioDAO;

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

        $respostasFinais = array_merge($respostas1_2, $respostas3);
        //die(var_dump($respostasFinais));
 
        if(count($respostas3) == count($questoes3)){
 
            //Enviar
            $usuario = $this->container->usuarioDAO->getUsuarioLogado();
            $idUsuario = $usuario->getId();
            $gravou = 0;
            
            if($idUsuario !== null){
                $id_questionario = $this->container->questionarioDAO->getIdByVersao($versaoAtual);
                $turma = $this->container->turmaDAO->getByDisciplinaCodigo($id_disciplina, 'A');
               
                if($turma !== null){
                    $avaliacao = $this->container->avaliacaoDAO->gravarAvaliacao($idUsuario, $turma->getID(), $id_questionario);
                   
                    if($avaliacao !== null){
                        $questoes = $this->container->questaoDAO->getAllByVersaoQuestionario($versaoAtual);
                        $professor_turma = $this->container->professorTurmaDAO->getByTurma($turma->getID());
                        
                        if($professor_turma !== null){
                            $this->container->respostaAvaliacaoDAO->gravarResposta($professor_turma->getId(), $avaliacao->getID(), $questoes, $respostasFinais);
                            $gravou = 1;
                        }
                    }
                }
                
            }
            if($gravou == 0){
                echo "<script>console.log('Erro ao gravar avaliação!' );</script>";
                die();
            }

                /*
                //Avaliação Pessoal
                $id_questionario = $this->container->questionarioDAO->getIdByTipoQuestionario($versaoAtual, 0);
                $avaliacao = $this->container->avaliacaoDAO->gravarAvaliacao($idUsuario, 1, $id_questionario);
                if($avaliacao !== null){
                    $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versaoAtual, 0);
                    $r0 = array();
                    $qtd = 0;
                    foreach ($questoes as $q)
                    {
                        $r0[] = $respostasFinais[$qtd];
                        $qtd++;
                    }
                    $this->container->respostaAvaliacaoDAO->gravarResposta(1, $avaliacao->getID(), $questoes, $r0);
                }
                else{
                    echo "<script>console.log('Erro ao gravar avaliação!' );</script>";
                    die();
                }
                
                //Avaliação do Professor
                $id_questionario = $this->container->questionarioDAO->getIdByTipoQuestionario($versaoAtual, 2);
                $avaliacao = $this->container->avaliacaoDAO->gravarAvaliacao($idUsuario, 1, $id_questionario);
                if($avaliacao !== null){
                    $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versaoAtual, 2);
                    $r2 = array();
                    foreach ($questoes as $q)
                    {
                        $r2[] = $respostasFinais[$qtd];
                        $qtd++;
                    }
                    $this->container->respostaAvaliacaoDAO->gravarResposta(1, $avaliacao->getID(), $questoes, $r2);
                }
                else{
                    echo "<script>console.log('Erro ao gravar avaliação!' );</script>";
                    die();
                }

                //Avaliação da Turma
                $id_questionario = $this->container->questionarioDAO->getIdByTipoQuestionario($versaoAtual, 1);
                $avaliacao = $this->container->avaliacaoDAO->gravarAvaliacao($idUsuario, 1, $id_questionario);
                if($avaliacao !== null){
                    $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versaoAtual, 1);
                    $r1 = array();
                    foreach ($questoes as $q)
                    {
                        $r1[] = $respostasFinais[$qtd];
                        $qtd++;
                    }
                    $this->container->respostaAvaliacaoDAO->gravarResposta(1, $avaliacao->getID(), $questoes, $r1);
                }
                else{
                    echo "<script>console.log('Erro ao gravar avaliação!' );</script>";
                    die();
                }
                */

                $usuario = $this->container->usuarioDAO->getUsuarioLogado();
                $this->container->view['usuario'] = $usuario;
                $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
                $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
                $this->container->view['versaoAtual'] = $versaoAtual;
                #return $this->container->view->render($response, 'avaliacoes.tpl');
                $this->container->view['completo'] = "Parabéns! Você concluiu uma avaliação!";
                return $this->index($request, $response, $args);
            
 
        }   else {
             
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage3.tpl');
        }
    }

}