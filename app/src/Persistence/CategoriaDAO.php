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
            $query = $this->em->createQuery("SELECT cat, ct FROM App\Model\Categoria AS cat LEFT JOIN cat.categoria_topicos AS ct");
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

    /**
     * @return Categoria[] |null
     */
    public function getByNome($nome)
    {
        try {
            $query = $this->em->createQuery("SELECT cat FROM App\Model\Categoria WHERE nome LIKE ':string'");
            $query->setParameter('string', $nome);
            $categorias = $query->getResult();
        } catch (\Exception $e) {
            $categorias = null;
        }
        return $categorias;
    }

    /**
     * @return Categoria[] |null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT cat FROM App\Model\Categoria AS cat WHERE cat.id = :id");
            $query->setParameter('id', $id);
            $categoria = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $categoria = null;
        }
        return $categoria;
    }

    public function getQuantidadeTopicos()
    {
        $sql = "SELECT categoria.id, COUNT(*) as quantidade FROM categoria JOIN topico ON categoria.id = topico.categoria GROUP BY topico.categoria;";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
