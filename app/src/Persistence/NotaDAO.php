<?php

namespace App\Persistence;

use App\Model\Disciplina;
use Doctrine\ORM\EntityManager;

class NotaDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

}
