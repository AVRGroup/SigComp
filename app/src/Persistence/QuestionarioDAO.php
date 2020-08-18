<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;
use App\Model\Questionario;
use App\Model\Avaliacao;
use App\Model\QuestaoQuestionario;
use App\Model\ProfessorTurma;
use App\Model\Turma;

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
     * @param $id
     */
    public function dropById($id)
    {
        try {
            $query = $this->em->createQuery("DELETE App\Model\QuestaoQuestionario q WHERE q.questionario = :id");
            $query->setParameter('id', $id);
            $query->execute();
        } catch (\Exception $e) {
            throw $e;  
        }
    
        try {
            $query = $this->em->createQuery("DELETE App\Model\Questionario q WHERE q.id = :id");
            $query->setParameter('id', $id);
            $query->execute();
        } catch (\Exception $e) {
            throw $e;  
        }
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
     * @param $id
     * @return string|null
     */
    public function getNameById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT qt FROM App\Model\Questionario as qt WHERE qt.id = :id");
            $query->setParameter('id', $id);
            $questionario = $query->getOneOrNullResult();
            $name = $questionario->getNome();
        } catch (\Exception $e) {
            $questionario = null;
            $name = null;
        }
        return $name;
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
            $query = $this->em->createQuery("SELECT qt FROM App\Model\Questionario as qt WHERE qt.nome = :nome");
            $query->setParameter('nome', $nome);
            $questionario = $query->getOneOrNullResult();
            if($questionario !== null){
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }        

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
     * @param $professor_id, $periodo, $questionario_id
     * @return boolean
     */
    public function requisitarQuestionarioByProfessor($professor_id, $periodo, $questionario_id){
        $professores_turmas;
        try {
            $query = $this->em->createQuery("SELECT pt FROM App\Model\ProfessorTurma as pt WHERE pt.professor = :professor_id AND pt.turma IN (SELECT t.id FROM App\Model\Turma as t WHERE t.periodo = :periodo)");
            $query->setParameter('professor_id', $professor_id);
            $query->setParameter('periodo', $periodo);
            $professores_turmas = $query->getResult();
        } catch (\Exception $e) {
            $professores_turmas = null;
        }

        if($professores_turmas){
            foreach($professores_turmas as $pt){
                $id = $pt->getId();
                try {
                    $sql_insert = "INSERT INTO db_gamificacao.questionario_professor_turma (`questionario_id`, `professorturma_id`) VALUES ({$questionario_id}, {$id});";
                    $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                    $stmt_insert->execute();
                } catch (\Exception $e) {
                    return null;
                }
            }
        }

        return true;
    }

    /**
     * @param $periodo, $questionario_id
     * @return boolean
     */
    public function requisitarQuestionarioByPeriodo($periodo, $questionario_id){
        $professores_turmas;
        try {
            $query = $this->em->createQuery("SELECT pt FROM App\Model\ProfessorTurma as pt WHERE pt.turma IN (SELECT t.id FROM App\Model\Turma as t WHERE t.periodo = :periodo)");
            $query->setParameter('periodo', $periodo);
            $professores_turmas = $query->getResult();
        } catch (\Exception $e) {
            $professores_turmas = null;
        }

        if($professores_turmas){
            foreach($professores_turmas as $pt){
                $id = $pt->getId();
                echo $id;
                try {
                    $sql_insert = "INSERT INTO db_gamificacao.questionario_professor_turma (`questionario_id`, `professorturma_id`) VALUES ({$questionario_id}, {$id});";
                    $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                    $stmt_insert->execute();
                } catch (\Exception $e) {
                    return null;
                }
            }
        }

        return true;
    }
}