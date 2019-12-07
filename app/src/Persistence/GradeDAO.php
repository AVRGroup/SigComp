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

    /**
     * @param $curso
     * @return Grade[] |null
     */
    public function getAllByCurso($curso)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grade AS g WHERE g.curso = :curso");
            $query->setParameter('curso', $curso);
            $grades = $query->getResult();
        } catch (\Exception $e) {
            $grades = null;
        }
        return $grades;
    }

    public function getByCodigo($codigo)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grade AS g WHERE g.codigo = :codigo");
            $query->setParameter('codigo', $codigo);
            $grade = $query->getResult();
        } catch (\Exception $e) {
            $grade = null;
        }
        return $grade;
    }

    public function getByCodigoCurso($codigo, $curso)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grade AS g WHERE g.codigo = :codigo AND g.curso = :curso");
            $query->setParameter('codigo', $codigo);
            $query->setParameter('curso', $curso);
            $grade = $query->getResult();
        } catch (\Exception $e) {
            $grade = null;
        }
        return $grade[0];
    }

    public function getFirstByCurso($curso)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grade AS g WHERE g.curso = :curso");
            $query->setParameter('curso', $curso);
            $grades = $query->getResult();
        } catch (\Exception $e) {
            $grades = null;
        }
        return $grades[0];
    }
}