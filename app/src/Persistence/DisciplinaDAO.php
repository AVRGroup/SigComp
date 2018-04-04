<?php

namespace App\Persistence;

use App\Model\Disciplina;
use Doctrine\ORM\EntityManager;

class DisciplinaDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Disciplina[] |null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT d FROM App\Model\Disciplina AS d");
            $disciplinas = $query->getResult();
        } catch (\Exception $e) {
            $disciplinas = null;
        }

        return $disciplinas;
    }
}
