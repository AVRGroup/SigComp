<?php

namespace App\Model;

/**
 * Model\MedalhaUsuario
 *
 * @ORM\Entity()
 * @ORM\Table(name="medalha_usuario")
 */
class MedalhaUsuario
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="medalhas_usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Medalha", inversedBy="medalhas_usuario")
     * @ORM\JoinColumn(name="medalha", referencedColumnName="id", nullable=false)
     */
    protected $medalha;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return MedalhaUsuario
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Medalha
     */
    public function getMedalha()
    {
        return $this->medalha;
    }

    /**
     * @param mixed $medalha
     * @return MedalhaUsuario
     */
    public function setMedalha($medalha)
    {
        $this->medalha = $medalha;
        return $this;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     * @return MedalhaUsuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

}