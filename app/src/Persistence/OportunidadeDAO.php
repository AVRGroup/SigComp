<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;

class OportunidadeDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

}


