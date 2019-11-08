<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;

class RespostaAvaliacaoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    public function truncateTable(){
        $sql = "TRUNCATE TABLE db_gamificacao.resposta_avaliacao;";
        $stmt= $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

}

