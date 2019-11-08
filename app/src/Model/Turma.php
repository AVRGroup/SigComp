<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model\Turma
 *
 * @ORM\Entity()
 * @ORM\Table(name="turma")
 */
class Turma 
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
     * @ORM\ManyToOne(targetEntity="Disciplina")
     * @ORM\JoinColumn(name="disciplina", referencedColumnName="id", nullable=false)
     */
    protected $disciplina;

    /**
     * @ORM\ManyToMany(targetEntity="Avaliacao", mappedBy="turma")
     */
    protected $avaliacoes; 

    /**
     * @ORM\OneToMany(targetEntity="ProfessorTurma", mappedBy="turma")
     * @ORM\JoinColumn(name="turma", referencedColumnName="id", nullable=false)
     */
    protected $turmas_professor;

    /**
     * @ORM\OneToMany(targetEntity="RespostaAvaliacao", mappedBy="turma")
     * @ORM\JoinColumn(name="turma", referencedColumnName="id", nullable=false)
     */
    protected $respostas_avaliacao;

    public function __construct()
    {
        $this->avaliacoes = new ArrayCollection();
        $this->turmas_professor = new ArrayCollection();
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
     * @return Turma
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
     * @return Turma
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisciplina()
    {
        return $this->disciplina;
    }

    /**
     * @param mixed $disciplina
     * @return Turma
     */
    public function setDisciplina($disciplina)
    {
        $this->disciplina = $disciplina;
        return $this;
    }

}