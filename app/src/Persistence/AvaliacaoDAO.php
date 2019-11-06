<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;

class AvaliacaoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Avaliacao[]|null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT a FROM App\Model\Avaliacao AS a");
            $avaliacoes = $query->getResult();
        } catch (\Exception $e) {
            $avaliacoes = null;
        }

        return $avaliacoes;
    }

    /**
     * @param $id
     * @return Avaliacao|null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT a FROM App\Model\Avaliacao AS a WHERE a.id = :id");
            $query->setParameter('id', $id);
            $avaliacao = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $avaliacao = null;
        }

        return $avaliacao;
    }

}