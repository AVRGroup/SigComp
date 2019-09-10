<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;

class MedalhaUsuarioDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    public function truncateTable(){
        $sql = "TRUNCATE TABLE db_gamificacao.medalha_usuario;";
        $stmt= $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

}

