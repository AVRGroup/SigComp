<?php

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Grade
 *
 * @ORM\Entity()
 * @ORM\Table(name="grade")
 */
class Grade implements ToIdArrayInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $codigo;


    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $curso;


    /**
     * @ORM\OneToMany(targetEntity="GradeDisciplina", mappedBy="grade")
     * @ORM\JoinColumn(name="grade", referencedColumnName="id", nullable=false)
     */
    protected $disciplinas_grade;

    public function __construct()
    {
        $this->disciplinas_grade = new ArrayCollection();
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
     * @return Grade
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
     * @return Grade
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisciplinas_grade()
    {
        return $this->disciplinas_grade;
    }

    /**
     * @return mixed
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param mixed $curso
     */
    public function setCurso($curso): void
    {
        $this->curso = $curso;
    }

    /**
     * @param mixed $disciplinas_grade
     * @return Grade
     */
    public function setDisciplinas_grade($disciplinas_grade)
    {
        $this->disciplinas_grade = $disciplinas_grade;
        return $this;
    }

    public function getIdentifier()
    {
        return $this->getCodigo();
    }
}