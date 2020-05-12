<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;
use App\Model\Avaliacao;
use App\Model\Turma;

class AvaliacaoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Avaliacao[]|null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT a FROM App\Model\Avaliacao AS a");
            $avaliacoes = $query->getResult();
        } catch (\Exception $e) {
            $avaliacoes = null;
        }

        return $avaliacoes;
    }

    /**
     * @param $id
     * @return Avaliacao|null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT a FROM App\Model\Avaliacao AS a WHERE a.id = :id");
            $query->setParameter('id', $id);
            $avaliacao = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $avaliacao = null;
        }

        return $avaliacao;
    }

    /**
     * @param $aluno_id, $turma_id
     * @return Avaliacao|null
     */
    public function gravarAvaliacao($aluno_id, $turma_id, $questionario_id)
    {
        $sql_insert = "INSERT INTO db_gamificacao.avaliacao (`data`, `aluno`, `turma`, `questionario`) VALUES (CURDATE(), {$aluno_id}, {$turma_id}, {$questionario_id})";
        $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
        $stmt_insert->execute();

        try {
            $query = $this->em->createQuery("SELECT a FROM App\Model\Avaliacao AS a WHERE a.aluno = :aluno_id AND a.turma = :turma_id AND a.questionario = :questionario_id");
            $query->setParameter('aluno_id', $aluno_id);
            $query->setParameter('turma_id', $turma_id);
            $query->setParameter('questionario_id', $questionario_id);
            $avaliacao = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $avaliacao = null;
        }

        return $avaliacao;

    }

    /**
     * @param $aluno_id
     * @return Integer[]|null
     */
    public function getAvaliacoesByAluno($aluno_id)
    {
        $turmas = array();
        try {
            $query = $this->em->createQuery("SELECT a FROM App\Model\Avaliacao AS a WHERE a.aluno = :aluno_id");
            $query->setParameter('aluno_id', $aluno_id);
            $avaliacoes = $query->getResult();
        } catch (\Exception $e) {
            $avaliacoes = null;
        }
        if($avaliacoes != null){
            foreach($avaliacoes as $a){
                $turmas[] = $a->getTurma();
            }
        }
        
        $disciplinas = array();

        if($turmas !== null){
            foreach($turmas as $t){
                $turma_id = $t->getId();
                try {
                    $query = $this->em->createQuery("SELECT t FROM App\Model\Turma AS t WHERE t.id = :turma_id");
                    $query->setParameter('turma_id', $turma_id);
                    $turma = $query->getOneOrNullResult();
                } catch (\Exception $e) {
                    $turma = null;
                }
                if($turma != null){
                    $disciplinas[] = $turma->getDisciplina()->getId();
                }
            }
        }

        return $disciplinas;
    }

}