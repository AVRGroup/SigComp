<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;
use App\Model\Questao;
use App\Model\Questionario;
use App\Model\QuestaoQuestionario;

class QuestaoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Questao[]|null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questao AS q");
            $questoes = $query->getResult();
        } catch (\Exception $e) {
            $questoes = null;
        }

        return $questoes;
    }

    /**
     * @param $id
     * @return Questao|null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questao AS q WHERE q.id = :id");
            $query->setParameter('id', $id);
            $questao = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questao = null;
        }

        return $questao;
    }

    /**
     * @param $id
     */
    public function dropById( $id )
    {
        try {
            $query = $this->em->createQuery("DELETE App\Model\QuestaoQuestionario q WHERE q.questao = :id");
            $query->setParameter('id', $id);
            $query->execute();
        } catch (\Exception $e) {
            throw e;  
        }

        try {
            $query = $this->em->createQuery("DELETE App\Model\Questao q WHERE q.id = :id");
            $query->setParameter('id', $id);
            $query->execute();
        } catch (\Exception $e) {
            throw e;  
        }
    }

    /**
     * @param $id, $enunciado
     */
    public function setEnunciado($id, $enunciado)
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questao AS q WHERE q.id = :id");
            $query->setParameter('id', $id);
            $questao = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questao = null;
        }
        if($questao){
            try {
                $query = $this->em->createQuery("UPDATE App\Model\Questao q SET q.enunciado = :enunciado WHERE q.id = :id");
                $query->setParameter('id', $id);
                $query->setParameter('enunciado', $enunciado);
                $query->execute();
            } catch (\Exception $e) {
            }
        }
    }


    /**
     * @param $versao, $categoria
     * @return Questao[] |null
     */
    public function getAllByTipoQuestionario($versao, $categoria)
    {
        try {
            $query = $this->em->createQuery("SELECT qt FROM App\Model\Questionario as qt WHERE qt.versao = :versao");
            $query->setParameter('versao', $versao);
            $questionario = $query->getOneOrNullResult();
            $id_questionario = $questionario->getId();
        } catch (\Exception $e) {
            $questionario = null;
            $id_questionario = null;
        }

        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\QuestaoQuestionario as q WHERE q.questionario = :id_questionario");
            $query->setParameter('id_questionario', $id_questionario);
            $questoes_questionario = $query->getResult();
        } catch (\Exception $e) {
            $id_questoes = null;
        }

        $questoes = array(); 

        foreach($questoes_questionario as $q){
            $questao = $q->getQuestao();
            $id = $questao->getID();
            try{
                $query = $this->em->createQuery("SELECT q FROM App\Model\Questao as q WHERE q.id = :id AND q.categoria = :categoria");
                $query->setParameter('id', $id);
                $query->setParameter('categoria', $categoria);
                $questao = $query->getOneOrNullResult();
                if($questao != null){
                    $questoes[] = $questao;
                }
            } catch(\Exception $e) {
                $questoes = null;
                break;
            }
            
        }  
        
        return $questoes;
    }

    /**
     * @param $versao
     * @return Questao[] |null
     */
    public function getAllByVersaoQuestionario($versao)
    {
        $questoes_questionario;
        try {
            $query = $this->em->createQuery("SELECT qt FROM App\Model\Questionario as qt WHERE qt.versao = :versao");
            $query->setParameter('versao', $versao);
            $questionario = $query->getOneOrNullResult();
            $id_questionario = $questionario->getId();
        } catch (\Exception $e) {
            $questionario = null;
            $id_questionario = null;
        }

        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\QuestaoQuestionario as q WHERE q.questionario = :id_questionario");
            $query->setParameter('id_questionario', $id_questionario);
            $questoes_questionario = $query->getResult();
        } catch (\Exception $e) {
            $id_questoes = null;
        }

        $questoes = array(); 

        foreach($questoes_questionario as $q){
            $questao = $q->getQuestao();
            $id = $questao->getID();
            try{
                $query = $this->em->createQuery("SELECT q FROM App\Model\Questao as q WHERE q.id = :id");
                $query->setParameter('id', $id);
                $questao = $query->getOneOrNullResult();
                if($questao != null){
                    $questoes[] = $questao;
                }
            } catch(\Exception $e) {
                $questoes = null;
                break;
            }
        }  
        
        return $questoes;  

    }

    /**
     * @param $versao, $categoria
     * @return Integer|null
     */
    public function getQtdByTipoQuestionario($versao, $categoria)
    {
        
        try {
            $query = $this->em->createQuery("SELECT qt FROM App\Model\Questionario as qt WHERE qt.versao = :versao");
            $query->setParameter('versao', $versao);
            $questionario = $query->getOneOrNullResult();
            $id_questionario = $questionario->getId();
        } catch (\Exception $e) {
            $questionario = null;
            $id_questionario = null;
        }

        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\QuestaoQuestionario as q WHERE q.questionario = :id_questionario");
            $query->setParameter('id_questionario', $id_questionario);
            $questoes_questionario = $query->getResult();
        } catch (\Exception $e) {
            $id_questoes = null;
        }

        $questoes = array(); 

        foreach($questoes_questionario as $q){
            $questao = $q->getQuestao();
            $id = $questao->getID();
            try{
                $query = $this->em->createQuery("SELECT q FROM App\Model\Questao as q WHERE q.id = :id AND q.categoria = :categoria");
                $query->setParameter('id', $id);
                $query->setParameter('categoria', $categoria);
                $questao = $query->getOneOrNullResult();
                if($questao !== null){
                    $questoes[] = $questao;
                }
            } catch(\Exception $e) {
                $questoes = null;
                break;
            }
            
        }  
        
        return sizeof($questoes);
    }

    public function inicializaQuestoes()
    {
        try {
            $sql_insert = "INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (1,1,'Você é pontual ?',0,1,0); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (3,3,'Você procurou o professor, tutor ou monitor da disciplina para tirar dúvidas ao longo do semestre?',0,1,0); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (2,2,'Você é assíduo às aulas?',0,1,0); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (4,4,'Você faz as atividades práticas propostas?',0,1,0); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (5,5,'Sua nota reflete de modo fiel o conhecimento que você reteve ao longo do curso?',0,1,0); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (6,6,'Você se dedicou à disciplina?',0,1,0); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (7,7,'Você possuía a base teórica necessária para cursar esta disciplina?',0,1,0); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`,`categoria`) VALUES (8,1,'O professor disponibilizou o plano de curso (objetivos, ementa, unidades de ensino, formas de avaliação, datas das avaliações, horário de atendimento e bibliografia) da disciplina na primeira semana de aula?',1,1,2); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`,`categoria`) VALUES (9,2,'O professor é pontual?',0,1,2); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (10,3,'O professor é assíduo às aulas?',0,1,2); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (11,4,'O professor cumpre o tempo de aula?',0,1,2); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (12,5,'O professor está disponível no horário de atendimento?',0,1,2); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (13,6,'O professor tira dúvidas em sala de aula?',0,1,2); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (14,7,'O professor demonstra dominar o conteúdo da disciplina?',0,1,2); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (15,8,'O professor apresenta exemplos em aula e faz ou propõe exercícios e/ou trabalhos práticos?',0,1,2); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (16,1,'O material utilizado em aula é atualizado?',0,1,1); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (17,2,'O conteúdo programático da disciplina foi cumprido?',0,1,1); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (18,3,'As avaliações refletem o conteúdo apresentado em sala?',0,1,1); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (19,4,'As notas das avaliações foram publicadas até três dias antes da avaliação seguinte?',0,1,1); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (20,5,'A bibliografia é adequada ao conteúdo da disciplina?',0,1,1); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (21,6,'Os objetivos da disciplina foram atendidos?',0,1,1); INSERT INTO db_gamificacao.questao (`id`,`numero`,`enunciado`,`tipo`,`questionario`, `categoria`) VALUES (22,7,'A ementa da disciplina é adequada?',0,1,1);";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        } catch (\Exception $e) {
        }   
    }

     /**
     * @param $numero, $enunciado, $tipo, $categoria
     * @return Integer[]|null
     */
    public function addQuestao($numero, $enunciado, $tipo, $categoria, $versao)
    {

        $questao = null;
        try{
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questao as q WHERE q.enunciado = :enunciado AND q.categoria = :categoria");
            $query->setParameter('categoria', $categoria);
            $query->setParameter('enunciado', $enunciado);
            $questao = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questao = null;
            echo "<script>console.log('deu ruim');</script>";
        }

        //Se não existe uma questão de categoria e enunciado igual, adiciona
        if($questao == null){

            try{
                $sql_insert = "INSERT INTO db_gamificacao.questao (`enunciado`,`tipo`, `categoria`) VALUES ('{$enunciado}',{$tipo}, {$categoria});";
                $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                $stmt_insert->execute();
            } catch (\Exception $e) {
                throw $e;
            }

            $questao = null;
            try{
                $query = $this->em->createQuery("SELECT q FROM App\Model\Questao as q WHERE q.enunciado = :enunciado AND q.categoria = :categoria");
                $query->setParameter('categoria', $categoria);
                $query->setParameter('enunciado', $enunciado);
                $questao = $query->getOneOrNullResult();
            } catch (\Exception $e) {
                $questao = null;
                echo "<script>console.log('deu ruim');</script>";
            }
        }

        try {
            $query = $this->em->createQuery("SELECT qt FROM App\Model\Questionario as qt WHERE qt.versao = :versao");
            $query->setParameter('versao', $versao);
            $questionario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            throw e;
        }
 
        $retorno = array();
        $retorno[] = $questionario;
        $retorno[] = $questao;

        return $retorno;

    }

    /**
     * @param $id, $numero
     */
    public function setNumero($id, $numero)
    {
        try {
            $query = $this->em->createQuery("UPDATE App\Model\Questao q SET q.numero = :numero WHERE q.id = :id");
            $query->setParameter('id', $id);
            $query->setParameter('numero', $numero);
            $query->execute();
        } catch (\Exception $e) {
        }
    }
}