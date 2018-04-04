<?php

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Disciplina
 *
 * @ORM\Entity()
 * @ORM\Table(name="disciplina")
 */
class Disciplina implements ToIdArrayInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    protected $codigo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $nome;

    /**
     * @ORM\Column(type="integer")
     */
    protected $carga;

    /**
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="disciplina")
     * @ORM\JoinColumn(name="disciplina", referencedColumnName="id", nullable=false)
     */
    protected $notas;

    public function __construct()
    {
        $this->notas = new ArrayCollection();
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
     * @return Disciplina
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     * @return Disciplina
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return Disciplina
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCarga()
    {
        return $this->carga;
    }

    /**
     * @param mixed $carga
     * @return Disciplina
     */
    public function setCarga($carga)
    {
        $this->carga = $carga;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * @param mixed $notas
     * @return Disciplina
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;
        return $this;
    }

    public function getIdentifier()
    {
        return $this->getCodigo();
    }
}