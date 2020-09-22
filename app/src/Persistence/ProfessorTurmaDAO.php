<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;
use App\Model\ProfessorTurma;
use App\Model\Usuario;

class ProfessorTurmaDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    public function truncateTable(){
        $sql = "TRUNCATE TABLE db_gamificacao.professor_turma;";
        $stmt= $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    /**
     * @param $turma
     * @return ProfessorTurma|null
     */
    public function getByTurma($turma)
    {
        
        try {
            $query = $this->em->createQuery("SELECT pt FROM App\Model\ProfessorTurma as pt WHERE pt.turma = :turma");
            $query->setParameter('turma', $turma);
            $professor_turma = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $professor_turma = null;
        }
        return $professor_turma;
    }

    /**
     * @param $turma
     * @return Usuario|null
     */
    public function getProfByTurma($turma)
    {
        
        try {
            $query = $this->em->createQuery("SELECT pt FROM App\Model\ProfessorTurma as pt WHERE pt.turma = 2");
            #$query->setParameter('turma', $turma);
            $professor_turma = $query->getOneOrNullResult();
            if($professor_turma != null){
                echo "<script>console.log('nn: " . $professor_turma->getProfessor() . "' );</script>";
            }
            $id_professor = $professor_turma->getProfessor();
            
        } catch (\Exception $e) {
            $id_professor = null;
        }

        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario as u WHERE u.id = :id_professor");
            $query->setParameter('id_professor', $id_professor);
            $professsor = $query->getOneOrNullResult();
            echo "<script>console.log('p: " . $id_professor . "' );</script>";
        } catch (\Exception $e) {
            $professor = null;
        }

        return $professor;
    }

    public function getTurmaByIdProfessor($prof_id)
    {
        
        try {
            $sql = "SELECT turma FROM professor_turma WHERE professor_turma.professor = $prof_id";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $results =  $stmt->fetchAll();
        } catch(\Exception $e){
            echo "Error";
        }

        foreach( $results as $r){
            try {
                $query = $this->em->createQuery("SELECT u FROM App\Model\Turma as u WHERE u.id = :id_turma");
                $query->setParameter('id_turma', $r['turma']);
                $turma = $query->getArrayResult();
            } catch (\Exception $e) {
                echo "Error";
            }
        }     

        return $turma;
    }

    /**
     * @param $id_professor, $id_turma
     * @return boolean
     */
    public function addProfessorTurma($id_professor, $id_turma)
    {
        try {
            $sql_insert = "INSERT INTO db_gamificacao.professor_turma (professor, turma) VALUES ({$id_professor}, {$id_turma})";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        } catch (\Exception $e) {
        }

        try {
            $query = $this->em->createQuery("SELECT pt FROM App\Model\ProfessorTurma AS pt WHERE pt.professor = :id_professor AND pt.turma = :id_turma");
            $query->setParameter('id_professor', $id_professor);
            $query->setParameter('id_turma', $id_turma);
            $prof_turma = $query->getOneOrNullResult();
            if($prof_turma !== null){
                return true;
            }
            else{
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

}

