<?php

namespace App\Persistence;

use App\Model\Certificado;
use App\Model\Usuario;
use Doctrine\ORM\EntityManager;

class CertificadoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Certificado[] |null
     */
    public function getAllByUsuario(Usuario $usuario)
    {
        try {
            $query = $this->em->createQuery("SELECT c, u FROM App\Model\Certificado AS c JOIN c.usuario AS u WHERE c.usuario = :usuario");
            $query->setParameter('usuario', $usuario);
            $certificados = $query->getResult();
        } catch (\Exception $e) {
            $certificados = null;
        }

        return $certificados;
    }

    /**
     * @return Certificado |null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT c, u FROM App\Model\Certificado AS c JOIN c.usuario AS u WHERE c.id = :id");
            $query->setParameter('id', $id);
            $certificados = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $certificados = null;
        }

        return $certificados;
    }

    /**
     * @return Certificado[] |null
     */
    public function getAllToReview()
    {
        try {
            $query = $this->em->createQuery("SELECT c, u FROM App\Model\Certificado AS c JOIN c.usuario AS u WHERE c.valido IS NULL ");
            $certificados = $query->getResult();
        } catch (\Exception $e) {
            $certificados = null;
        }

        return $certificados;
    }
}


