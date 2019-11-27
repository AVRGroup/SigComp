<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;

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
    public function gravarAvaliacao($aluno_id, $turma_id)
    {
        $sql_insert = "INSERT INTO db_gamificacao.avaliacao (`data`, `aluno`, `turma`) VALUES (CURDATE(), {$aluno_id}, {$turma_id})";
        $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
        $stmt_insert->execute();

        try {
            $query = $this->em->createQuery("SELECT a FROM App\Model\Avaliacao AS a WHERE a.aluno = :aluno_id AND a.turma = :turma_id");
            $query->setParameter('aluno_id', $aluno_id);
            $query->setParameter('turma_id', $turma_id);
            $avaliacao = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $avaliacao = null;
        }

        return $avaliacao;

    }

}