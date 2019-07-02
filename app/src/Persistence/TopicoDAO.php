<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;
use App\Model\Topico;

class TopicoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @param $categoria
     * @return Topico[]|null
     */
    public function getAllByCategory($categoria)
    {
        try {
            $query = $this->em->createQuery("SELECT t FROM App\Model\Topico AS t LEFT JOIN t.categoria AS cat WHERE cat.id = :categoria");
            $query->setParameter('categoria', $categoria);
            $topicos = $query->getResult();
        } catch (\Exception $e) {
            $topicos = null;
        }
        return $topicos;
    }

    /**
     * @param $categoria
     * @return Topico[]|null
     */
    public function getInInsertionOrder($categoria)
    {
        try {
            $query = $this->em->createQuery("SELECT t FROM App\Model\Topico AS t LEFT JOIN t.categoria AS cat WHERE cat.id = :categoria ORDER BY t.id");
            $query->setParameter('categoria', $categoria);
            $topicos = $query->getResult();
        } catch (\Exception $e) {
            $topicos = null;
        }
        return $topicos;
    }

    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT t FROM App\Model\Topico as t WHERE t.id = :id");
            $query->setParameter('id', $id);
            $topico = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $topico = null;
        }
        return $topico;
    }

}