<?php

namespace App\Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Model\CertificadosDiarios
 *
 * @ORM\Entity()
 * @ORM\Table(name="certificados_diarios")
 */

class CertificadosDiarios {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $quantidade_certificados;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getQuantidadeCertificados()
    {
        return $this->quantidade_certificados;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $quantidade_certificados
     */
    public function setQuantidadeCertificados($quantidade_certificados): void
    {
        $this->quantidade_certificados = $quantidade_certificados;
    }
}