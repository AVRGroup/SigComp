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

    public function getCursos()
    {
        try {
            $query = $this->em->createQuery("SELECT DISTINCT u.curso FROM App\Model\Grade AS u");
            $cursos = $query->getResult();
        } catch (\Exception $e) {
           var_dump( $e->getMessage());
        }
        return $cursos;
    }

     /**
     * @param $codigo
     * @return Grade|null
     */
    public function getByCodigo($codigo)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grade AS g WHERE g.codigo = :codigo");
            $query->setParameter('codigo', $codigo);
            $grade = $query->getOneOrNullResult();
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

    public function deletaGrade($grade_id)
    {
        if($grade_id !== null){
            try{
                $sql = "DELETE FROM db_gamificacao.grade_disciplina WHERE grade = $grade_id";
                $stmt = $this->em->getConnection()->prepare($sql);
                $stmt->execute();

                $sql = "DELETE FROM db_gamificacao.grade WHERE id = $grade_id";
                $stmt = $this->em->getConnection()->prepare($sql);
                $stmt->execute();

            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

}