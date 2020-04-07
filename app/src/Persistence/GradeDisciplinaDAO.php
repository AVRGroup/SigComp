<?php

namespace App\Persistence;

use App\Model\GradeDisciplina;
use Doctrine\ORM\EntityManager;

class GradeDisciplinaDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @param array $periodos
     * @return GradeDisciplina[]
     */
    public function getByPeriodo(array $periodos)
    {
        try {
            $query = $this->em->createQuery("SELECT gd FROM App\Model\GradeDisciplina AS gd WHERE u.periodo IN (:periodos)");
            $query->setParameter('periodos', $periodos);
            $gradeDisciplinas = $query->getResult();
        } catch (\Exception $e) {
            $gradeDisciplinas = [];
        }

        return $gradeDisciplinas;
    }

    public function disciplinaExisteNaGrade($disciplina, $grade)
    {
        try {
            $query = $this->em->createQuery("SELECT gd FROM App\Model\GradeDisciplina as gd WHERE gd.grade = :grade AND gd.disciplina = :disciplina");
            $query->setParameter('grade', $grade);
            $query->setParameter('disciplina', $disciplina);
            $existe = $query->getResult();
        } catch (\Exception $e) {
            $existe = false;
        }

        if ($existe) {
            return true;
        }

        return false;
    }
}
