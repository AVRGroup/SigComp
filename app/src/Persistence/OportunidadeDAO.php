<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;

class OportunidadeDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT o FROM App\Model\Oportunidade as o");
            $certificados = $query->getResult();
        } catch (\Exception $e) {
            $certificados = null;
        }

        return $certificados;
    }
}


