<?php


namespace App\Persistence;


use Doctrine\ORM\EntityManager;

class GrupoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    public function getGrupoById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grupo AS g WHERE g.id = :id");
            $query->setParameter('id', $id);
            $grupo = $query->getResult();
        } catch (\Exception $e) {
            $grupo = null;
        }

        return $grupo;
    }

    public function getAllByCurso($curso)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grupo AS g WHERE g.curso = :curso");
            $query->setParameter('curso', $curso);
            $grupo = $query->getResult();
        } catch (\Exception $e) {
            $grupo = null;
        }

        return $grupo;
    }
}