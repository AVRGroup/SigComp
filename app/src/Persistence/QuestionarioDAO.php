<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;
use App\Model\Questionario;
use App\Model\Avaliacao;

class QuestionarioDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Questionario[]|null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questionario AS q");
            $questionario = $query->getResult();
        } catch (\Exception $e) {
            $questionario = null;
        }

        return $questionario;
    }

    /**
     * @param $id
     * @return Questionario|null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questionario AS q WHERE q.id = :id");
            $query->setParameter('id', $id);
            $questionario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questionario = null;
        }

        return $questionario;
    }

    /**
     * @return int|null
     */
    public function getUltimaVersao()
    {
        try {
            $query = $this->em->createQuery("SELECT MAX(q.versao) FROM App\Model\Questionario AS q");
            $questionario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questionario = null;
        }

        return $questionario;
    }

    /**
     * @param $versao
     * @return int|null
     */
    public function getIdByVersao($versao)
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
        return $id_questionario;
    }

    /**
     * @param $id, $nome
     */
    public function setNome($id, $nome){
        try {
            $query = $this->em->createQuery("UPDATE App\Model\Questionario q SET q.nome = :nome WHERE q.id = :id");
            $query->setParameter('id', $id);
            $query->setParameter('nome', $nome);
            $query->execute();
        } catch (\Exception $e) {
        }
    }

    /**
     * @param $id
     * @return int|null
     */
    public function possuiAvaliacao($id){
        try {
            $query = $this->em->createQuery("SELECT COUNT(a) FROM App\Model\Avaliacao as a WHERE a.questionario = :id");
            $query->setParameter('id', $id);
            $qtd_avaliacoes = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $qtd_avaliacoes = null;
        }

        return $qtd_avaliacoes;
    }

    /**
     * @param $versao, $nome
     * @return Questionario|null
     */
    public function newQuestionario($versao, $nome){

        try {
            $sql_insert = "INSERT INTO db_gamificacao.questionario (`versao`, `nome`) VALUES ({$versao}, '{$nome}');";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        } catch (\Exception $e) {
            return null;
        }
        
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questionario as q WHERE q.versao = :versao");
            $query->setParameter('versao', $versao);
            $questionario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questionario = null;
        }
        
        return $questionario;
    }

    /**
     * @param $versao
     * @return Questionario|null
     */
    public function newQuestionarioSemNome($versao){

        try {
            $sql_insert = "INSERT INTO db_gamificacao.questionario (`versao`, `nome`) VALUES ({$versao}, CURRENT_TIMESTAMP());";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        } catch (\Exception $e) {
            return null;
        }
        
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questionario as q WHERE q.versao = :versao");
            $query->setParameter('versao', $versao);
            $questionario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questionario = null;
        }
        
        return $questionario;
    }

    /**
     * @return Integer|null
     */
    public function getUltimoNaoAvaliado(){
        $id_questionario = null;
        try {
            $sql = "SELECT q.id FROM db_gamificacao.questionario as q WHERE q.id NOT IN (SELECT a.questionario FROM db_gamificacao.avaliacao as a)";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $id_questionario =  $stmt->fetchAll();
        } catch (\Exception $e) {
        }

        return $id_questionario;
    }

    /**
     * @param $id_questionario
     * @return Questionario|null
     */
    public function limpaQuestionario($id_questionario){
        try {
            $query = $this->em->createQuery("DELETE App\Model\QuestaoQuestionario q WHERE q.questionario = :id_questionario");
            $query->setParameter('id_questionario', $id_questionario);
            $query->execute();
        } catch (\Exception $e) {
            throw e;  
        }

        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questionario AS q WHERE q.id = :id_questionario");
            $query->setParameter('id_questionario', $id_questionario);
            $questionario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questionario = null;
        }

        return $questionario;
    }

}