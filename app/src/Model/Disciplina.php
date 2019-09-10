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
     * @ORM\Column(type="integer", options={"default" : 100})
     */
    protected $experiencia = 100;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $fatorInteligencia = 20;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $fatorCarisma = 20;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $fatorSabedoria = 20;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $fatorDestreza = 20;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $fatorForca = 20;

    /**
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="disciplina")
     * @ORM\JoinColumn(name="disciplina", referencedColumnName="id", nullable=false)
     */
    protected $notas;

    /**
     * @ORM\OneToMany(targetEntity="GradeDisciplina", mappedBy="disciplina")
     * @ORM\JoinColumn(name="disciplina", referencedColumnName="id", nullable=false)
     */
    protected $disciplinas_grade;


    /**
     * @ORM\ManyToMany(targetEntity="Oportunidade", mappedBy="disciplina")
     */
    protected $oportunidades;

    public function __construct()
    {
        $this->notas = new ArrayCollection();
        $this->oportunidades = new ArrayCollection();
    }


    public function addOportunidade(Oportunidade $oportunidade)
    {
        $this->oportunidades[] = $oportunidade;
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
     * @return mixed
     */
    public function getExperiencia()
    {
        return $this->experiencia;
    }

    /**
     * @param mixed $experiencia
     * @return Disciplina
     */
    public function setExperiencia($experiencia)
    {
        $this->experiencia = $experiencia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFatorInteligencia()
    {
        return $this->fatorInteligencia;
    }

    /**
     * @param mixed $fatorInteligencia
     * @return Disciplina
     */
    public function setFatorInteligencia($fatorInteligencia)
    {
        $this->fatorInteligencia = $fatorInteligencia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFatorCarisma()
    {
        return $this->fatorCarisma;
    }

    /**
     * @param mixed $fatorCarisma
     * @return Disciplina
     */
    public function setFatorCarisma($fatorCarisma)
    {
        $this->fatorCarisma = $fatorCarisma;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFatorSabedoria()
    {
        return $this->fatorSabedoria;
    }

    /**
     * @param mixed $fatorSabedoria
     * @return Disciplina
     */
    public function setFatorSabedoria($fatorSabedoria)
    {
        $this->fatorSabedoria = $fatorSabedoria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFatorDestreza()
    {
        return $this->fatorDestreza;
    }

    /**
     * @param mixed $fatorDestreza
     * @return Disciplina
     */
    public function setFatorDestreza($fatorDestreza)
    {
        $this->fatorDestreza = $fatorDestreza;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFatorForca()
    {
        return $this->fatorForca;
    }

    /**
     * @param mixed $fatorForca
     * @return Disciplina
     */
    public function setFatorForca($fatorForca)
    {
        $this->fatorForca = $fatorForca;
        return $this;
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