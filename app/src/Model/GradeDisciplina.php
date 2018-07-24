<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model\GradeDisciplina
 *
 * @ORM\Entity()
 * @ORM\Table(name="grade_disciplina")
 */
class GradeDisciplina
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Grade", inversedBy="disciplinas_grade")
     * @ORM\JoinColumn(name="grade", referencedColumnName="id", nullable=false)
     */
    protected $grade;

    /**
     * @ORM\Column(type="integer")
     */
    protected $periodo;

    /**
     * @ORM\ManyToOne(targetEntity="Disciplina", inversedBy="disciplinas_grade")
     * @ORM\JoinColumn(name="disciplina", referencedColumnName="id", nullable=false)
     */
    protected $disciplina;

    /**
     * 0: Eletiva
     * 1: Obrigatoria
     *
     * @ORM\Column(type="smallint", options={"default" : 0})
     */
    protected $tipo = 0;

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
     * @return GradeDisciplina
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param mixed $grade
     * @return GradeDisciplina
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @param mixed $periodo
     * @return GradeDisciplina
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }


    /**
     * @return Disciplina
     */
    public function getDisciplina()
    {
        return $this->disciplina;
    }

    /**
     * @param mixed $disciplina
     * @return GradeDisciplina
     */
    public function setDisciplina($disciplina)
    {
        $this->disciplina = $disciplina;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     * @return GradeDisciplina
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

}