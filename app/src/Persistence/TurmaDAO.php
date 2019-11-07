<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;

class TurmaDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Turma[]|null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT t FROM App\Model\Turma AS t");
            $turmas = $query->getResult();
        } catch (\Exception $e) {
            $turmas = null;
        }

        return $turmas;
    }

    /**
     * @param $id
     * @return Turma|null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT t FROM App\Model\Turma AS t WHERE t.id = :id");
            $query->setParameter('id', $id);
            $turmas = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $turmas = null;
        }

        return $turmas;
    }

    /**
     * @param $disciplina
     * @return Turma[] |null
     */
    public function getAllByDisciplina($disciplina)
    {
        try {
            $query = $this->em->createQuery("SELECT t FROM App\Model\Turma AS t WHERE t.disciplina = :disciplina");
            $query->setParameter('disciplina', $disciplina);
            $turmas = $query->getResult();
        } catch (\Exception $e) {
            $turmas = null;
        }
        return $turmas;
    }
}