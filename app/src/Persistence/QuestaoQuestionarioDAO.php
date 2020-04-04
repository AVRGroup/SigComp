<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;
use App\Model\QuestaoQuestionario;
use App\Model\Questao;
use App\Model\Questionario;

class QuestaoQuestionarioDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    public function truncateTable(){
        $sql = "TRUNCATE TABLE db_gamificacao.questao_questionario;";
        $stmt= $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    /**
     * @param $id
     * @return QuestaoQuestionario|null
     */
    public function getById($id)
    { 
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\QuestaoQuestionario as q WHERE q.id = :id");
            $query->setParameter('id', $id);
            $questao_questionario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questao_questionario = null;
        }
        return $questao_questionario;
    }

     /**
     * @param $versao, $id_questao
     * @return Integer|null
     */
    public function getNumeroQuestao($versao, $id_questao)
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
            $query = $this->em->createQuery("SELECT q FROM App\Model\QuestaoQuestionario as q WHERE q.questionario = :id_questionario AND q.questao = :id_questao");
            $query->setParameter('id_questionario', $id_questionario);
            $query->setParameter('id_questao', $id_questao);
            $q = $query->getOneOrNullResult();
            if($q != null){
                $numero = $q->getNumero();
            }
        } catch (\Exception $e) {
            $numero = null;
        }
        return $numero;
    }

    /**
    * @param $versao, $id_questao, $numero
    */
    public function setNumeroQuestao($versao, $id_questao, $numero)
    {
        $id_questionario = null;
        try {
            $query = $this->em->createQuery("SELECT qt FROM App\Model\Questionario as qt WHERE qt.versao = :versao");
            $query->setParameter('versao', $versao);
            $questionario = $query->getOneOrNullResult();
            if($questionario !== null){
                $id_questionario = $questionario->getId();
            }
        } catch (\Exception $e) {
            $questionario = null;
            $id_questionario = null;
        }

        try {
            $sql_update = $this->em->createQuery("UPDATE App\Model\QuestaoQuestionario q SET q.numero = :numero WHERE q.questionario = :id_questionario AND q.questao = :id_questao");
            $sql_update->setParameter('id_questionario', $id_questionario);
            $sql_update->setParameter('id_questao', $id_questao);
            $sql_update->setParameter('numero', $numero);
            $sql_update->execute();
        } catch (\Exception $e) {
        }
    }

    /**
     * @param $id_questao, $versao_questionario
     */
    public function dropOne($id_questao, $id_questionario)
    {
        try {
            $query = $this->em->createQuery("DELETE App\Model\QuestaoQuestionario q WHERE q.questao = :id_questao AND q.questionario = :id_questionario");
            $query->setParameter('id_questao', $id_questao);
            $query->setParameter('id_questionario', $id_questionario);
            $query->execute();
        } catch (\Exception $e) {
            
        }
    }

}