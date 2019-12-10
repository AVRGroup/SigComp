<?php

namespace App\Persistence;

use App\Model\Disciplina;
use Doctrine\ORM\EntityManager;

class DisciplinaDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Disciplina[] |null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT d FROM App\Model\Disciplina AS d");
            $disciplinas = $query->getResult();
        } catch (\Exception $e) {
            $disciplinas = null;
        }

        return $disciplinas;
    }

    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT d FROM App\Model\Disciplina AS d WHERE d.id = :id");
            $query->setParameter('id', $id);
            $disciplina = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $disciplina = null;
        }

        return $disciplina;
    }

    public function getByCodigo($codigo)
    {
        try {
            $query = $this->em->createQuery("SELECT d FROM App\Model\Disciplina AS d WHERE d.codigo = :codigo");
            $query->setParameter('codigo', $codigo);
            $disciplina = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            $disciplina = null;
        }

        return $disciplina;
    }

    public function getByGrade($grade)
    {
        try {
            $query = $this->em->createQuery("SELECT d FROM App\Model\Disciplina AS d LEFT JOIN d.disciplinas_grade AS dg WHERE dg.grade = :grade");
            $query->setParameter('grade', $grade);
            $disciplinas = $query->getResult();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            $disciplinas = null;
        }

        return $disciplinas;
    }
}
