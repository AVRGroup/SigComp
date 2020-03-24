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
            $nome_questionario = $questionario->getNome();
            $this->container->view['nome_questionario'] = $nome_questionario;
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

        $alterou = 0; //Variável de controle de alterações
        $editou = 0;
        $excluiu = 0;
        $adicionou = 1;

        //Checa se houveram alterações
        #Edições
        foreach($questoes as $questao){
            $id_questao = $questao->getId();
            $novo_enunciado = $request->getParsedBodyParam("edita_$id_questao");
            #compara o enunciado entre a nova questão e a original. Se houver mudanças, persiste
            if($novo_enunciado !== $questao->getEnunciado()){
                $alterou ++;
                $editou ++;
                break;
            }
        }

        #Exclusões
        if($alterou == 0){
            foreach($questoes as $questao){
                $id_questao = $questao->getId();
                
                if (isset($_POST["exclui_$id_questao"])) {
                    $alterou ++;
                    $excluiu ++;
                    break;
                }
            }
        }

        #Adições
        if($alterou == 0){
            if($request->getParsedBodyParam("add_prof_$adicionou")){
                $alterou ++;
                $adicionou ++;
            }
            elseif($request->getParsedBodyParam("add_pes_$adicionou")){
                $alterou ++;
                $adicionou ++;
            }
            elseif($request->getParsedBodyParam("add_tur_$adicionou")){
                $alterou ++;
                $adicionou ++;
            }
        }
       
        //Resolvendo a versão do questionário
        $nome_questionario = $request->getParsedBodyParam("nome_questionario");
        $novo_nome = $request->getParsedBodyParam("novo_nome");
        $versao_atual = $request->getParsedBodyParam("versao");
        $id_questionario = $this->container->questionarioDAO->getIdByVersao($versao_atual);
        
        //1- alterou só o nome
        if($alterou == 0 && $novo_nome !== $nome_questionario){
            echo "<script>console.log('alterou só nome: " . $novo_nome . " != " . $nome_questionario . "' );</script>";
            if($id_questionario !== null){
                $this->container->questionarioDAO->setNome($id_questionario, $novo_nome);
            }
        }
        
        //2- alterou só questões
        elseif ($alterou !== 0 && $novo_nome == $nome_questionario) {
            echo "<script>console.log('ñ alterou nome: " . $novo_nome . " = " . $nome_questionario . " ' );</script>";
            $num_avaliacoes = $this->container->questionarioDAO->possuiAvaliacao($id_questionario);
            $num_avaliacoes = (int)$num_avaliacoes[1];
            if($num_avaliacoes == null || $num_avaliacoes == 0){
                //aplica as modificações
            }
            else{
                //tem que alterar o nome
            }
        }
        
        //3- alterou os dois
        elseif($alterou !==0 && $novo_nome !== $nome_questionario){
            echo "<script>console.log('alterou os dois: " . $novo_nome . " != " . $nome_questionario . "' );</script>";
            
            $num_avaliacoes = $this->container->questionarioDAO->possuiAvaliacao($id_questionario);
            $num_avaliacoes = (int)$num_avaliacoes[1];
            if($num_avaliacoes > 0){
                //Cria novo questionario e add questões
            }
        }

        //Aplicando as alterações
        #Loop que aplica as edições
        if($editou > 0){
            foreach($questoes as $questao){
                $id_questao = $questao->getId();
                $novo_enunciado = $request->getParsedBodyParam("edita_$id_questao");
                #compara o enunciado entre a nova questão e a original. Se houver mudanças, persiste
                if($novo_enunciado !== $questao->getEnunciado()){
                    $this->container->questaoDAO->setEnunciado($id_questao, $novo_enunciado);
                }
            }
        }

        #Loop que aplica as exclusões
        if($excluiu > 0){
            foreach($questoes as $questao){
                $id_questao = $questao->getId();
                
                if (isset($_POST["exclui_$id_questao"])) {
                    $this->excluiQuestao($request, $response, $args, $id_questao);
                    unset($_POST["exclui_$id_questao"]);
                }
            }
        }

        #Loop que aplica adições
        if($adicionou > 1){
            #Avaliação do Professor
            $adicionou = 1;
            while($request->getParsedBodyParam("add_prof_$adicionou")){
                $enunciado = $request->getParsedBodyParam("add_prof_$adicionou");
                $numero = $this->container->questaoDAO->getQtdByTipoQuestionario(1, 2);
                $numero = (int)$numero[1];
                $numero ++;
                $this->container->questaoDAO->addQuestao($numero, $enunciado, 0, 1, 2);
                $adicionou ++;
                //echo "<script>console.log('adicionou: " . $enunciado . "' );</script>";
            }

            #Avaliação Pessoal
            $adicionou = 1;
            while($request->getParsedBodyParam("add_pes_$adicionou")){
                $enunciado = $request->getParsedBodyParam("add_pes_$adicionou");
                $numero = $this->container->questaoDAO->getQtdByTipoQuestionario(1, 0);
                $numero = (int)$numero[1];
                $numero ++;
                $this->container->questaoDAO->addQuestao($numero, $enunciado, 0, 1, 0);
                $adicionou ++;
                //echo "<script>console.log('adicionou: " . $enunciado . "' );</script>";
            }

            #Avaliação da Turma
            $adicionou = 1;
            while($request->getParsedBodyParam("add_tur_$adicionou")){
                $enunciado = $request->getParsedBodyParam("add_tur_$adicionou");
                $numero = $this->container->questaoDAO->getQtdByTipoQuestionario(1, 1);
                $numero = (int)$numero[1];
                $numero ++;
                $this->container->questaoDAO->addQuestao($numero, $enunciado, 0, 1, 1);
                $adicionou ++;
                //echo "<script>console.log('adicionou: " . $enunciado . "' );</script>";
            }
        }

        $this->listaQuestoes($request, $response, $args);
    }
    
    public function excluiQuestao(Request $request, Response $response, $args, $id_questao)
    {
        $questao = $this->container->questaoDAO->getById($id_questao);
        if($questao !== null){
            $numero = $questao->getNumero();
            $categoria = $questao->getCategoria();
            $versao = $request->getParsedBodyParam("versao");

            $this->container->questaoDAO->dropById($id_questao);

            //Decrementa número das questões posteriores
            $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versao, $categoria);
            foreach($questoes as $q){
                if($q->getNumero() > $numero){
                    $this->container->questaoDAO->setNumero($q->getId(), $q->getNumero() - 1);
                }
            }
        }
        //$this->listaQuestoes($request, $response, $args);
    }
}