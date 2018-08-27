<?php

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Medalha
 *
 * @ORM\Entity()
 * @ORM\Table(name="medalha")
 */
class Medalha implements ToIdArrayInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $nome;

    /**
     * @ORM\OneToMany(targetEntity="MedalhaUsuario", mappedBy="medalha")
     * @ORM\JoinColumn(name="medalha", referencedColumnName="id", nullable=false)
     */
    protected $medalhas_usuario;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $imagem;

    public function __construct()
    {
        $this->medalhas_usuario = new ArrayCollection();
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
     * @return Medalha
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getIdentifier()
    {
        return $this->getCodigo();
    }

    /**
     * @return mixed
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * @param mixed $imagem
     * @return Medalha
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }
}

