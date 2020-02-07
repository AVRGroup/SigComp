<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;
use App\Model\Questionario;

class QuestionarioDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Questionario[]|null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questionario AS q");
            $questionario = $query->getResult();
        } catch (\Exception $e) {
            $questionario = null;
        }

        return $questionario;
    }

    /**
     * @param $id
     * @return Questionario|null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questionario AS q WHERE q.id = :id");
            $query->setParameter('id', $id);
            $questionario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questionario = null;
        }

        return $questionario;
    }

}