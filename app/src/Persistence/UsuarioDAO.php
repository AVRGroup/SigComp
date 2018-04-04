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
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.id = :id");
            $query->setParameter('id', $id);
            $user = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $user = null;
        }

        return $user;
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
            $users = $query->getResult();
        } catch (\Exception $e) {
            $users = [];
        }

        return $users;
    }

}
