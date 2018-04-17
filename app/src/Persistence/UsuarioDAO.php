<?php

namespace App\Persistence;

use App\Model\Disciplina;
use App\Model\Usuario;
use Doctrine\ORM\EntityManager;

class UsuarioDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @param $id
     * @return Usuario|null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT u,c FROM App\Model\Usuario AS u LEFT JOIN u.certificados AS c WHERE u.id = :id");
            $query->setParameter('id', $id);
            $usuario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $usuario = null;
        }

        return $usuario;
    }

    /**
     * @param array $matriculas
     * @return Usuario[]
     */
    public function getByMatricula(array $matriculas)
    {
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.matricula IN (:matriculas)");
            $query->setParameter('matriculas', $matriculas);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = [];
        }

        return $usuarios;
    }

    /**
     * @return Usuario[] |null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u");
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

}
