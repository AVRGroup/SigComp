<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model\Certificado
 *
 * @ORM\Entity()
 * @ORM\Table(name="certificado")
 */
class Certificado
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="certificados")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    protected $usuario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $extensao;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $caminho;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $valid;

    public function __construct()
    {
    }

}