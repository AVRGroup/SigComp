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

        $ultimaVersao = (int) $this->container->questionarioDAO->getUltimaVersao();
        $nome = $this->container->questionarioDAO->getNameById($ultimaVersao);
        $this->container->view['ultima_versao'] = $nome;

        //$this->container->questaoDAO->inicializaQuestoes();
        
        return $this->container->view->render($response, 'edicaoQuestionario.tpl');
    }

    public function listaQuestoes(Request $request, Response $response, $args)
    {
        $base_url = $request->getParsedBodyParam("base_url");
        $filtro = 0; 

        if(!empty($args)){
            $versao = $args;
            $categoria = $request->getParsedBodyParam("filtro_categoria");
            $filtro = 1;
            echo "<script>console.log('entrou no if da versao ". $versao ."');</script>";
            //die(var_dump($versao));
        }

        elseif($request->getParsedBodyParam("filtro_versao") == null){
            $this->container->view['incompleto'] = "Selecione um filtro!";
            return $this->index($request, $response, $args);
        }

        elseif($request->getParsedBodyParam("filtro_versao") !== null){
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
            $cursos = $this->container->usuarioDAO->getCursos();
            $this->container->view['cursos'] = $cursos; 
            return $this->container->view->render($response, 'edicaoQuestoes.tpl'); 
            #header("Location: $base_url/edicaoQuestoes.tpl");

        }
        /*
        else{
            $usuario = $this->container->usuarioDAO->getUsuarioLogado();
            $this->container->view['usuario'] = $usuario;
            $questionarios = $this->container->questionarioDAO->getAll();
            $this->container->view['questionarios'] = $questionarios;
            $this->container->view['incompleto'] = "Selecione um filtro!";
            $this->container->view->render($response, 'edicaoQuestionario.tpl');
            #header("Location: $base_url/edicaoQuestionario.tpl");
        }
        */
    }
    
    public function storeQuestoes(Request $request, Response $response, $args)
    {
        $base_url = $request->getParsedBodyParam("base_url");
        $versao = $request->getParsedBodyParam("versao");
        $categoria = $request->getParsedBodyParam("categoria");

        //Checa se é para excluir o questionário
        if (isset($_POST["excluirQuestionario"])){
            unset($_POST["excluirQuestionario"]);
            if($this->excluiQuestionario($request, $response, $args) !== 0){
                $this->container->view['completo'] = "Você excluiu o questionário com sucesso!";
                return $this->index($request, $response, $args);
            }
            else{
                $this->container->view['incompleto'] = "Não é possível excluir o questionário em questão, pois ele possui avaliações.";
                return $this->listaQuestoes($request, $response, $args);
            }
        }

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
            
            //Se não tem avaliações neste questionário, muda o nome
            if($num_avaliacoes == null || $num_avaliacoes == "0"){
                $this->container->questionarioDAO->setNome($id_questionario, $novo_nome);
            }
            //Se já tem avaliação, cria um novo
            else{
                //criar novo questionário
                $nova_versao = $this->criarQuestionario($request, $response, $args);
                if($nova_versao !== null){
                    $versao = $nova_versao;
                    $this->container->view['versao'] = $versao;
                    echo "<script>console.log('ELSE 1');</script>";
                }
                else{
                    $this->container->view['incompleto'] = "Esse nome já existe!";
                    return $this->listaQuestoes($request, $response, $args);
                }
            }
        }
        
        // 2- alterou só questões
        elseif ($alterou !== 0 && $novo_nome == $nome_questionario) {
            echo "<script>console.log('não alterou nome: " . $novo_nome . " = " . $nome_questionario . " ' );</script>";

            echo "<script>console.log('num av. = " . $num_avaliacoes . " ');</script>";
            
            //Se já tem avaliação, não deixar modificar sem criar um novo (ou seja, deve alterar o nome)
            if($num_avaliacoes !== null && $num_avaliacoes !== "0"){
                $this->container->view['incompleto'] = "Esse questionário já possui avaliações. 
                                                        Você precisa alterar o nome do questionário ao alterar as questões!";
                return $this->listaQuestoes($request, $response, $args);
            }
        }
        
        // 3- alterou os dois
        elseif($alterou !== 0 && $novo_nome !== $nome_questionario){
            //echo "<script>console.log('alterou os dois: " . $novo_nome . " != " . $nome_questionario . "' );</script>";
            //Cria novo questionario
            $nova_versao = $this->criarQuestionario($request, $response, $args);
            if($nova_versao !== null){
                $versao = $nova_versao;
                $this->container->view['versao'] = $versao;
                echo "<script>console.log('Criando novo questionario');</script>";
            }
            else{
                $this->container->view['incompleto'] = "Esse nome já existe!";
                return $this->listaQuestoes($request, $response, $args);
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
                $qtd = $this->container->questaoQuestionarioDAO->jaUsada($questao->getId());
                $qtd = $qtd[1];
                if($novo_enunciado !== $questao->getEnunciado()){
                    if($qtd !== "0" && $qtd !== null){
                        //cria nova
                        $versao_antiga = $request->getParsedBodyParam("versao");
                        $numero = $numero = $this->container->questaoQuestionarioDAO->getNumeroQuestao($versao_antiga, $questao->getId());
                        $a = $this->container->questaoDAO->addQuestao($numero, $novo_enunciado, 0, $questao->getCategoria(), $versao);
                        $questionario = $a[0];
                        $questao_nova = $a[1];
                        if($questao_nova !== null){
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
                if($questao !== null){
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
                if($questao !== null){
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
                if($questao !== null){
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
                }
                
                $adicionou ++;
                //echo "<script>console.log('adicionou: " . $enunciado . "' );</script>";
            }
        }
        
        $this->container->view['completo'] = "As alterações foram salvas com sucesso!";
        return $this->listaQuestoes($request, $response, $versao);
    }
    
    public function excluiQuestao(Request $request, Response $response, $versao, $id_questao)
    {
        $questao = $this->container->questaoDAO->getById($id_questao);
        if($questao !== null){
            echo "<script>console.log('questao != null');</script>";
            $numero = $this->container->questaoQuestionarioDAO->getNumeroQuestao($versao, $id_questao);
            $categoria = $questao->getCategoria();

            //se foi usada
            //retira relaçao
            $qtd_uso = $this->container->questaoQuestionarioDAO->jaUsada($questao->getId());
            $qtd_uso = $qtd_uso[1];
            if($qtd_uso !== "1"){
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

        //Cria um novo com o nome passado
        $novo_nome = $request->getParsedBodyParam("novo_nome");
        $questionario = $this->container->questionarioDAO->newQuestionario($nova_versao, $novo_nome);

        if($questionario !== null){
            $versao_antiga = $request->getParsedBodyParam("versao");
            $questoes_antigas = $this->container->questaoDAO->getAllByVersaoQuestionario($versao_antiga);
            foreach($questoes_antigas as $questao){
                if($questao !== null){
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
            }
            return $questionario->getVersao();
        }
        else {
            return null;
        }

    }

    public function excluiQuestionario(Request $request, Response $response, $args)
    {
        $versao = $request->getParsedBodyParam("versao");
        $id = $this->container->questionarioDAO->getIdByVersao($versao);
        $num_avaliacoes = $this->container->questionarioDAO->possuiAvaliacao($id);
        $num_avaliacoes = $num_avaliacoes[1];
        if($num_avaliacoes == null || $num_avaliacoes == "0"){
            $this->container->questionarioDAO->dropById($id);
            return 1;
        }
        else{
            return 0;
        }
    }
}