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
    public function getValidatedByUsuario(Usuario $usuario)
    {
        try {
            $query = $this->em->createQuery("SELECT c, u FROM App\Model\Certificado AS c JOIN c.usuario AS u WHERE c.usuario = :usuario AND c.valido = 1 ORDER BY c.data_inicio ASC");
            $query->setParameter('usuario', $usuario);
            $certificados = $query->getResult();
        } catch (\Exception $e) {
            $certificados = null;
        }

        return $certificados;
    }

    public function getAllByUsuario(Usuario $usuario)
    {
        try {
            $query = $this->em->createQuery("SELECT c, u FROM App\Model\Certificado AS c JOIN c.usuario AS u WHERE c.usuario = :usuario ORDER BY c.data_inicio ASC");
            $query->setParameter('usuario', $usuario);
            $certificados = $query->getResult();
        } catch (\Exception $e) {
            $certificados = null;
        }

        return $certificados;
    }

    public function getTotalHoras($id)
    {
        try {
            $query = $this->em->createQuery("SELECT SUM(num_horas) FROM App\Model\Certificado AS total WHERE usuario = :id");
            $query->setParameter('id', $id);
            $total_horas = $query->getResult();
        } catch (\Exception $e) {
            $total_horas = null;
        }

        return $total_horas;
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

    public function incrementNumberOfCertificates()
    {
        $sql = "UPDATE db_gamificacao.certificados_diarios SET quantidade_certificados = quantidade_certificados + 1 WHERE id = 1";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }
    
    public function getNumberOfCertificates()
    {
        $sql = "SELECT quantidade_certificados FROM db_gamificacao.certificados_diarios WHERE id = 1";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();
        return $results;
    }

    public function setNumberOfCertificates()
    {
        $sql = "UPDATE db_gamificacao.certificados_diarios SET quantidade_certificados = 0 WHERE id = 1";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }
}


