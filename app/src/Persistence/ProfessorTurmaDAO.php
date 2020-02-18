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

}

