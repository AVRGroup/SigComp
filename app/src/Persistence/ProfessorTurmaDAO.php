<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;

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

}

