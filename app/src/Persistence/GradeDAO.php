<?php

namespace App\Persistence;

use App\Model\Grade;
use App\Model\GradeDisciplina;
use App\Model\Disciplina;
use Doctrine\ORM\EntityManager;

class GradeDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Grade[]|null
     */
    public function getAllFetched()
    {
        try {
            $query = $this->em->createQuery("SELECT g,d,p, FROM App\Model\Grade AS g LEFT JOIN g.disciplinas_grade AS d LEFT JOIN d.periodo AS p");
            $grades = $query->getResult();
        } catch (\Exception $e) {
            $grades = null;
        }

        return $grades;
    }

    /**
     * @return Grade[] |null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grade AS g");
            $grades = $query->getResult();
        } catch (\Exception $e) {
            $grades = null;
        }
        return $grades;
    }
}