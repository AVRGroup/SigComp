<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;

/**
 * Model\Questionario
 *
 * @ORM\Entity()
 * @ORM\Table(name="questionario", uniqueConstraints={@UniqueConstraint(name="unique_questionario", columns={"periodo", "tipo_questionario"})})
 */
class Questionario
{

    //Tipos de questionário
    const AVALIACAO_PESSOAL = 0;

    const AVALIACAO_TURMA = 1;

    const AVALIACAO_PROFESSOR = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $periodo;
    
    /**
     * 0: Avaliacao_Pessoal
     * 1: Avaliacao_Turma
     * 2: Avaliacao_Professor
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $tipo_questionario = 0;

    /**
     * @ORM\OneToMany(targetEntity="Questao", mappedBy="questionario")
     * @ORM\JoinColumn(name="questionario", referencedColumnName="id", nullable=false)
     */
    protected $questoes_questionario;

    /**
     * @ORM\OneToMany(targetEntity="Avaliacao", mappedBy="questionario")
     * @ORM\JoinColumn(name="questionario", referencedColumnName="id", nullable=false)
     */
    protected $avaliacoes_questionario;

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
     * @return Questionario
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Questionario
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoQuestionario()
    {
        return $this->tipo_questionario;
    }

    /**
     * @param mixed $tipo_questionario
     * @return Questionario
     */
    public function setTipoQuestionario($tipo_questionario)
    {
        $this->tipo_questionario = $tipo_questionario;
        return $this;
    }

}