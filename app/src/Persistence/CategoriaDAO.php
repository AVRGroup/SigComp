<?php

namespace App\Persistence;

use App\Model\Categoria;
use Doctrine\ORM\EntityManager;

class CategoriaDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Categoria[]|null
     */
    public function getAllFetched()
    {
        try {
            $query = $this->em->createQuery("SELECT cat,d FROM App\Model\Categoria AS cat LEFT JOIN cat.categoria_topicos AS ct");
            $categorias = $query->getResult();
        } catch (\Exception $e) {
            $categorias = null;
        }

        return $categorias;
    }

    /**
     * @return Categoria[] |null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT cat FROM App\Model\Categoria AS cat");
            $categorias = $query->getResult();
        } catch (\Exception $e) {
            $categorias = null;
        }
        return $categorias;
    }
}
