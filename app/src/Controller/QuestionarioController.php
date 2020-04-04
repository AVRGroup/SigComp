<?php
namespace App\Controller;
require __DIR__ . '/../../../vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Usuario;
use App\Model\Questao;
use App\Model\RespostaAvaliacao;
use App\Model\Questionario;
use App\Model\QuestaoQuestionario;

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

        if(!empty($args)){
            $versao = $args[0];
            $categoria = $request->getParsedBodyParam("filtro_categoria");
            $filtro = 1;
            echo "<script>console.log('entrou no if da versao');</script>";
        }

        //die(var_dump($args));

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
            $this->container->view['questaoQuestionarioDAO'] = $this->container->questaoQuestionarioDAO;
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
                    echo "<script>console.log('EXCLUIU');</script>";
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

        //Checa quantas avaliações tem aquele questionário
        $num_avaliacoes = $this->container->questionarioDAO->possuiAvaliacao( $id_questionario );
        $num_avaliacoes = $num_avaliacoes[1];
        
        // 1- alterou só o nome
        if($alterou == 0 && $novo_nome !== $nome_questionario){

            echo "<script>console.log('alterou só nome: " . $novo_nome . " != " . $nome_questionario . "' );</script>";
            
            if($num_avaliacoes == null || $num_avaliacoes == "0"){
                $this->container->questionarioDAO->setNome($id_questionario, $novo_nome);
            }
            else{
                //criar novo questionário
                $nova_versao = $this->criarQuestionario($request, $response, $args);
                $versao = $nova_versao;
                $this->container->view['versao'] = $versao;
                echo "<script>console.log('ELSE 1');</script>";
            }
        }
        
        // 2- alterou só questões
        elseif ($alterou !== 0 && $novo_nome == $nome_questionario) {
            echo "<script>console.log('não alterou nome: " . $novo_nome . " = " . $nome_questionario . " ' );</script>";

            echo "<script>console.log('num av. = " . $num_avaliacoes . " ');</script>";
            
            if($num_avaliacoes !== null && $num_avaliacoes !== "0"){
                $novo_nome = "data";
                $nova_versao = $this->criarQuestionario($request, $response, $novo_nome);
                $versao = $nova_versao;
                $this->container->view['versao'] = $versao; 
                echo "<script>console.log('IF2');</script>";
            }
        }
        
        // 3- alterou os dois
        elseif($alterou !== 0 && $novo_nome !== $nome_questionario){
            //echo "<script>console.log('alterou os dois: " . $novo_nome . " != " . $nome_questionario . "' );</script>";
            if($num_avaliacoes !== null && $num_avaliacoes !== "0"){
                //Cria novo questionario
                 $nova_versao = $this->criarQuestionario($request, $response, $args);
                 $versao = $nova_versao;
                 $this->container->view['versao'] = $versao;
                 echo "<script>console.log('IF3 ');</script>";
            }
        }

        //Carregando as questoes do novo questionario, se foi gerado um novo
        if($categoria == "3"){
            $questoes = $this->container->questaoDAO->getAllByVersaoQuestionario($versao);
        }
        else{
            $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versao, $categoria);
        }

        //Aplicando as alterações
        #Loop que aplica as edições
        if($editou > 0){
            foreach($questoes as $questao){
                $id_questao = $questao->getId();
                $novo_enunciado = $request->getParsedBodyParam("edita_$id_questao");
                #compara o enunciado entre a nova questão e a original. Se houver mudanças, persiste
                $num_respostas = $this->container->respostaAvaliacaoDAO->jaUsada($questao->getId());
                $num_respostas = $num_respostas[1];
                if($novo_enunciado !== $questao->getEnunciado()){
                    if($num_respostas !== "0" && $num_respostas !== null){
                        //cria nova
                        $versao_antiga = $request->getParsedBodyParam("versao");
                        $numero = $numero = $this->container->questaoQuestionarioDAO->getNumeroQuestao($versao_antiga, $questao->getId());
                        $a = $this->container->questaoDAO->addQuestao($numero, $novo_enunciado, 0, $questao->getCategoria(), $versao);
                        $questionario = $a[0];
                        $questao_nova = $a[1];
                        try {
                            $q = new QuestaoQuestionario();
                            $q->setQuestao($questao_nova);
                            $q->setQuestionario($questionario);
                            $q->setNumero($numero);
                            $this->container->questaoQuestionarioDAO->persist($q);
                            $this->container->questaoQuestionarioDAO->flush();

                            $id_questionario = $this->container->questionarioDAO->getIdByVersao($versao);
                            $this->container->questaoQuestionarioDAO->dropOne($questao->getId(), $id_questionario);
                        } catch (\Exception $e) {
                            throw $e;
                        }
                    }      

                    //senão
                    else{
                        $this->container->questaoDAO->setEnunciado($id_questao, $novo_enunciado);
                    }
                }
            }
        }

        #Loop que aplica as exclusões
        if($excluiu > 0){
            foreach($questoes as $questao){
                $id_questao = $questao->getId();
                
                if (isset($_POST["exclui_$id_questao"])) {
                    echo "<script>console.log('CHAMA ESCLUSAO');</script>";
                    $this->excluiQuestao($request, $response, $versao, $id_questao);
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
                $numero = $this->container->questaoDAO->getQtdByTipoQuestionario($versao, 2);
                $numero = (int)$numero[1];
                $numero ++;
                
                $a = $this->container->questaoDAO->addQuestao($numero, $enunciado, 0, 2, $versao);
                $questionario = $a[0];
                $questao = $a[1];
                try {
                    $q = new QuestaoQuestionario();
                    $q->setQuestao($questao);
                    $q->setQuestionario($questionario);
                    $q->setNumero($numero);
                    $this->container->questaoQuestionarioDAO->persist($q);
                    $this->container->questaoQuestionarioDAO->flush();
                } catch (\Exception $e) {
                    throw $e;
                }   

                $adicionou ++;
                //echo "<script>console.log('adicionou: " . $enunciado . "' );</script>";
            }

            #Avaliação Pessoal
            $adicionou = 1;
            while($request->getParsedBodyParam("add_pes_$adicionou")){
                $enunciado = $request->getParsedBodyParam("add_pes_$adicionou");
                $numero = $this->container->questaoDAO->getQtdByTipoQuestionario($versao, 0);
                $numero = (int)$numero[1];
                $numero ++;

                $a = $this->container->questaoDAO->addQuestao($numero, $enunciado, 0, 0, $versao);
                $questionario = $a[0];
                $questao = $a[1];
                try {
                    $q = new QuestaoQuestionario();
                    $q->setQuestao($questao);
                    $q->setQuestionario($questionario);
                    $q->setNumero($numero);
                    $this->container->questaoQuestionarioDAO->persist($q);
                    $this->container->questaoQuestionarioDAO->flush();
                } catch (\Exception $e) {
                    throw $e;
                }   

                $adicionou ++;
                //echo "<script>console.log('adicionou: " . $enunciado . "' );</script>";
            }

            #Avaliação da Turma
            $adicionou = 1;
            while($request->getParsedBodyParam("add_tur_$adicionou")){
                $enunciado = $request->getParsedBodyParam("add_tur_$adicionou");
                $numero = $this->container->questaoDAO->getQtdByTipoQuestionario($versao, 1);
                $numero = (int)$numero[1];
                $numero ++;

                $a = $this->container->questaoDAO->addQuestao($numero, $enunciado, 0, 1, $versao);
                $questionario = $a[0];
                $questao = $a[1];
                try {
                    $q = new QuestaoQuestionario();
                    $q->setQuestao($questao);
                    $q->setQuestionario($questionario);
                    $q->setNumero($numero);
                    $this->container->questaoQuestionarioDAO->persist($q);
                    $this->container->questaoQuestionarioDAO->flush();
                } catch (\Exception $e) {
                    throw $e;
                }   
                
                $adicionou ++;
                //echo "<script>console.log('adicionou: " . $enunciado . "' );</script>";
            }
        }
        
        $this->listaQuestoes($request, $response, $versao);
    }
    
    public function excluiQuestao(Request $request, Response $response, $versao, $id_questao)
    {
        $questao = $this->container->questaoDAO->getById($id_questao);
        if($questao !== null){
            echo "<script>console.log('questao != null');</script>";
            $numero = $this->container->questaoQuestionarioDAO->getNumeroQuestao($versao, $id_questao);
            $categoria = $questao->getCategoria();

            //se foi usada
            //retira relção
            $num_respostas = $this->container->respostaAvaliacaoDAO->jaUsada($questao->getId());
            $num_respostas = $num_respostas[1];
            if($num_respostas !== "0" && $num_respostas !== null){
                $id_questionario = $this->container->questionarioDAO->getIdByVersao($versao);
                
                echo "<script>console.log('id_questionario: " . $id_questionario . " ');</script>";
                $qid = $questao->getId();
                echo "<script>console.log('id_questao: " . $qid . " ');</script>";
                
                $this->container->questaoQuestionarioDAO->dropOne($questao->getId(), $id_questionario);
            }

            else{
                echo "<script>console.log('DROP');</script>";
                $this->container->questaoDAO->dropById($id_questao);
            }

            //Decrementa número das questões posteriores
            $questoes = $this->container->questaoDAO->getAllByTipoQuestionario($versao, $categoria);
            foreach($questoes as $q){
                $novo_numero = $this->container->questaoQuestionarioDAO->getNumeroQuestao($versao, $q->getId());
                if($novo_numero > $numero){
                    $this->container->questaoQuestionarioDAO->setNumeroQuestao($versao, $q->getId(), $novo_numero - 1);
                }
            }
        }

        
    }

    public function criarQuestionario(Request $request, Response $response, $args)
    {
        $nova_versao = $this->container->questionarioDAO->getUltimaVersao();
        $nova_versao = $nova_versao[1];
        $nova_versao++;
        echo "<script>console.log('nova_versao: " . $nova_versao . " ');</script>";

        //Cria novo questionário

        //Se tem algum questionário ainda não respondido, edita este
        $id_questionario = $this->container->questionarioDAO->getUltimoNaoAvaliado();
        if(!empty($id_questionario)){
            $id_questionario = $id_questionario[0];
            $id_questionario = $id_questionario['id'];
        }
        else{
            $id_questionario == null;
        }
        if($id_questionario !== null){
            //limpa questionário para fazer a cópia
            $questionario = $this->container->questionarioDAO->limpaQuestionario($id_questionario);
            $versao_antiga = $request->getParsedBodyParam("versao");
            $novo_nome = $request->getParsedBodyParam("novo_nome");
            $id_antigo = $this->container->questionarioDAO->getIdByVersao($versao_antiga);
            $questionario_antigo = $this->container->questionarioDAO->getById($id_antigo);
            if($novo_nome !== $questionario_antigo->getNome()){
                $this->container->questionarioDAO->setNome($id_questionario, $novo_nome);
            }
        }

        //Se precisa criar um novo e o usuário não mudou o nome, cria um com nome genérico contendo a data e hora de criação
        elseif($args !== null){
            $questionario = $this->container->questionarioDAO->newQuestionarioSemNome($nova_versao);
        }

        //Senão cria um novo com o nome passado
        else{
            $novo_nome = $request->getParsedBodyParam("novo_nome");
            $questionario = $this->container->questionarioDAO->newQuestionario($nova_versao, $novo_nome);
        }

        $versao_antiga = $request->getParsedBodyParam("versao");
        $questoes_antigas = $this->container->questaoDAO->getAllByVersaoQuestionario($versao_antiga);
        foreach($questoes_antigas as $questao){
            try {
                $q = new QuestaoQuestionario();
                $q->setQuestao($questao);
                $q->setQuestionario($questionario);
                $numero = $this->container->questaoQuestionarioDAO->getNumeroQuestao($versao_antiga, $questao->getId());
                $q->setNumero($numero);
                $this->container->questaoQuestionarioDAO->persist($q);
                $this->container->questaoQuestionarioDAO->flush();
            } catch (\Exception $e) {
                throw $e;
            }   
        }

        return $questionario->getVersao();

    }
}