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
use App\Model\ProfessorTurma;

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
        $disciplinas_avaliadas = $this->container->avaliacaoDAO->getAvaliacoesByAluno($usuario->getId());
        $periodoPassado = $this->getPeriodoPassado();
        $notas_usuario = $usuario->getNotas();

        $cont = 0;
        $cont2 = 0;
        foreach ( $notas_usuario as $nota){
            if ( $nota->getPeriodo() == $periodoPassado){  
                #Cont que verifica quantas disciplinas o usuario teve no periodo passado
                $cont = $cont + 1;
                foreach ($disciplinas_avaliadas as $disci) {
                    if ($disci == $nota->getDisciplina()->getId()) {
                        #Cont pra ver quantas disciplinas do periodo passado foram avaliadas
                        $cont2 = $cont2 + 1;
                    }
                }
            }
        }
        if( $cont == $cont2 ){
            $this->container->view['concluiu'] = "OK";
        }

        $this->container->view['disciplinas_avaliadas'] = $disciplinas_avaliadas;
        $this->container->view['usuario'] = $usuario;
        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
        
        #USAR SOMENTE PRA INICIALIZAR AS QUESTOES NO BANCO COM ACENTO
        //$this->container->questaoDAO->inicializaQuestoes();
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
            $this->container->view['verificacao'] = true;
            return $this->container->view->render($response, 'avaliacaoPage3.tpl');

        }   else {
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage2.tpl');
        }
    }

    #Store da page que vai apresentar a medalha do usuario que fez as avaliaçoes
    public function storePageMedalhas(Request $request, Response $response, $args)
    {
        $verificacao = $request->getParsedBodyParam("verificacao");
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $periodoPassado = $this->getPeriodoPassado();
        $notas_usuario = $usuario->getNotas();
        $disciplinas_avaliadas = $this->container->avaliacaoDAO->getAvaliacoesByAluno($usuario->getId());
        $versaoAtual = $this->container->questionarioDAO->getUltimaVersao();
        
        #Verificação e atribuição de medalhas 
        $cont = 0;
        $cont2 = 0;
        foreach ($notas_usuario as $nota){
            if ($nota->getPeriodo() == $periodoPassado){  
                #Cont que verifica quantas disciplinas o usuario teve no periodo passado
                $cont = $cont + 1;
                foreach ($disciplinas_avaliadas as $disci) {
                    if ($disci == $nota->getDisciplina()->getId()) {
                        #Cont pra ver quantas disciplinas do periodo passado foram avaliadas
                        $cont2 = $cont2 + 1;
                    }
                }
            }
        }
        #Caso o usuário tenha concluido todas as avaliaçoes, a page com a medalha dele sera exibida
        #Essa $verificacao serve pra saber se o espertinho ta tentando acessar a page de medalha editando a URL!
        if( $cont == $cont2 && $verificacao == true){
            $this->container->usuarioDAO->addAvaliacaoInUser($usuario->getId());
            $avaliacoes = $this->container->usuarioDAO->getNumAvaliacoes($usuario->getId());
        
           if( $avaliacoes > 0  && $avaliacoes <= 2 ){
               $medalhasUser = $this->container->usuarioDAO->possuiMedalhaById($usuario->getId(), 40);
               if( $medalhasUser == true ){
                    $this->container->view['nomeMedalha'] = "AVALIADOR JÚNIOR";
                    $this->container->view['numImgMedalha'] = 1;
                } else {
                    $this->container->usuarioDAO->addMedalhaById($usuario->getId(), 40);
                    $this->container->view['nomeMedalha'] = "AVALIADOR JÚNIOR";
                    $this->container->view['numImgMedalha'] = 1;
                }
           } 
           elseif ( $avaliacoes > 2 && $avaliacoes <= 4){
            $medalhasUser = $this->container->usuarioDAO->possuiMedalhaById($usuario->getId(), 41);
                if( $medalhasUser == true ){
                    $this->container->view['nomeMedalha'] = "AVALIADOR PLENO";
                    $this->container->view['numImgMedalha'] = 2;
                } else {
                    $this->container->usuarioDAO->addMedalhaById($usuario->getId(), 41);
                    $this->container->view['nomeMedalha'] = "AVALIADOR PLENO";
                    $this->container->view['numImgMedalha'] = 2;
                }
           }  
           elseif ( $avaliacoes > 4 && $avaliacoes <= 6){
            $medalhasUser = $this->container->usuarioDAO->possuiMedalhaById($usuario->getId(), 42);
                if( $medalhasUser == true ){
                    $this->container->view['nomeMedalha'] = "AVALIADOR SENIOR";
                    $this->container->view['numImgMedalha'] = 3;
                } else {
                    $this->container->usuarioDAO->addMedalhaById($usuario->getId(), 42);
                    $this->container->view['nomeMedalha'] = "AVALIADOR SENIOR";
                    $this->container->view['numImgMedalha'] = 3;
                }
           } 
           elseif ( $avaliacoes > 6 ){
            $medalhasUser = $this->container->usuarioDAO->possuiMedalhaById($usuario->getId(), 43);
                if( $medalhasUser == true ){
                    $this->container->view['nomeMedalha'] = "AVALIADOR MASTER";
                    $this->container->view['numImgMedalha'] = 4;
                } else {
                    $this->container->usuarioDAO->addMedalhaById($usuario->getId(), 43);
                    $this->container->view['nomeMedalha'] = "AVALIADOR MASTER";
                    $this->container->view['numImgMedalha'] = 4;
                }
           } 
        } else {
            $versaoAtual = $this->container->questionarioDAO->getUltimaVersao();
            $usuario = $this->container->usuarioDAO->getUsuarioLogado();
            $this->container->view['usuario'] = $usuario;
            $this->container->view['versaoAtual'] = $versaoAtual;
            $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
            $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
            $this->container->view['completo'] = "Parabéns, você concluiu uma avaliação.";
            return $this->index($request, $response, $args);
        }

        $this->container->view['usuario'] = $usuario;
        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
        $this->container->view['versaoAtual'] = $versaoAtual;
        return $this->container->view->render($response, 'avaliacaoPageMedalhas.tpl');
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
        $codigoTurma = null;

        $this->container->view['questaoQuestionarioDAO'] = $this->container->questaoQuestionarioDAO;

        #Abaixo começa o processo de gravar as respostas
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
  
        if(count($respostas3) == count($questoes3)){

            #Abaixo é feita a requisição do token pro serviço funcionar 
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://oauth.integra-h.nrc.ice.ufjf.br/oauth/token",
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => array('grant_type' => 'password','password' => '','username' => ''),
              CURLOPT_HTTPHEADER => array(
                "Authorization: Basic dGVzdGU6dGVzdGU="
              ),
            ));
            $resultado = json_decode(curl_exec($curl), true);
            curl_close($curl);

            $token = $resultado['access_token'];

            #Abaixo o serviço é executado, retornando as relações necessárias de turma-aluno-professor
            $curl2 = curl_init();
            $usuario = $this->container->usuarioDAO->getUsuarioLogado();
            $matricula = $this->container->usuarioDAO->getMatricula($usuario->getId());
            $perPassado = str_split($this->getPeriodoPassado(), 1);

            curl_setopt_array($curl2, array(
                CURLOPT_URL => "https://apisiga.integra-h.nrc.ice.ufjf.br/aluno/" . $matricula . "/" . $perPassado[0] . $perPassado[1] . $perPassado[2] . $perPassado[3] . "/" . $perPassado[4] . "/turmas",
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer $token"
                ),
            ));

            $servico = json_decode(curl_exec($curl2), true);

            #Checa se a disciplina existe e adiciona a turma 
            $periodoAtual = $this->getPeriodoAtual();
            foreach($servico as $service ){
                $disc = $this->container->disciplinaDAO->getByCodigo($service['disciplina']['codigo']);
                if( $disc != null ){
                    $turma = $this->container->turmaDAO->addTurma($disc->getId(), $service['turma'], $periodoAtual);
                }

                #Checa se o professor existe, caso nao, cria
                foreach($service['professores'] as $professor){
                    $prof = $this->container->usuarioDAO->getUserByMatricula($professor['siape']);
                    if( $prof == null ){
                        $prof = $this->container->usuarioDAO->addProfessor($professor['nome'], $professor['siape']);
                    } 
                    $teste = $this->container->professorturmaDAO->addProfessorTurma($prof->getId(), $turma->getId());
                }
            }

            echo "OK";
            die();
 
            $usuario = $this->container->usuarioDAO->getUsuarioLogado();
            $idUsuario = $usuario->getId();
            $gravou = 0;

            #Loop pra pegar o codigo da turma do aluno
            foreach( $servico as $service){
                $disc->$this->container->disciplinaDAO->getByCodigo($service['disciplina']['codigo']);
                if( $disc->getId() == $id_disciplina ){
                    $codigoTurma = $service['turma'];
                    break;
                }
            }
            
            #Enviar as respostas
            if($idUsuario !== null){
                $id_questionario = $this->container->questionarioDAO->getIdByVersao($versaoAtual);
                $turma = $this->container->turmaDAO->getByDisciplinaCodigo($id_disciplina, $codigoTurma);                   
               
                if($turma !== null){
                    $avaliacao = $this->container->avaliacaoDAO->gravarAvaliacao($idUsuario, $turma->getId(), $id_questionario);
                   
                    if($avaliacao !== null){
                        $questoes = $this->container->questaoDAO->getAllByVersaoQuestionario($versaoAtual);
                        $professor_turma = $this->container->professorTurmaDAO->getByTurma($turma->getId());
                        
                        if($professor_turma !== null){
                            $this->container->respostaAvaliacaoDAO->gravarResposta($professor_turma->getId(), $avaliacao->getId(), $questoes, $respostasFinais);
                            $gravou = 1;
                        }
                    }
                }
                
            }
            if($gravou == 0){
                echo "<script>console.log('Erro ao gravar avaliação!' );</script>";
                die();
            }

                $usuario = $this->container->usuarioDAO->getUsuarioLogado();
                $this->container->view['usuario'] = $usuario;
                $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
                $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
                $this->container->view['versaoAtual'] = $versaoAtual;

                return $this->storePageMedalhas($request, $response, $args);
        }else {
            $this->container->view['incompleto'] = "Preencha todos os campos de resposta!";
            return $this->container->view->render($response, 'avaliacaoPage3.tpl');
        }
    }

}