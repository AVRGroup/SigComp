<?php

namespace App\Model;

use App\Model\Questao;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;

/**
 * Model\RespostaAvaliacao
 *
 * @ORM\Entity()
 * @ORM\Table(name="resposta_avaliacao", uniqueConstraints={@UniqueConstraint(name="unique_resposta_avaliacao", columns={"avaliacao", "questao"})})
 */
class RespostaAvaliacao
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="ProfessorTurma", inversedBy="avaliacao")
     * @ORM\JoinColumn(name="professor_turma", referencedColumnName="id", nullable=true)
     */
    protected $professor_turma;

    /**
     * @ORM\ManyToOne(targetEntity="Avaliacao", inversedBy="resposta_avaliacao")
     * @ORM\JoinColumn(name="avaliacao", referencedColumnName="id", nullable=false)
     */
    protected $avaliacao;

    /**
     * @ORM\ManyToOne(targetEntity="Questao", inversedBy="resposta_avaliacao")
     * @ORM\JoinColumn(name="questao", referencedColumnName="id", nullable=false)
     */
    protected $questao;

    /**
     * @ORM\Column(type="smallint", length=255, nullable=false)
     */
    protected $resposta;

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
     * @return RespostaAvaliacao
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Turma
     */
    public function getTurma()
    {
        return $this->turma;
    }

    /**
     * @param mixed $turma
     * @return RespostaAvaliacao
     */
    public function setMedalha($turma)
    {
        $this->turma = $turma;
        return $this;
    }

    /**
     * @return Usuario
     */
    public function getProfessor()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $professor
     * @return RespostaAvaliacao
     */
    public function setUsuario($professor)
    {
        $this->professor = $professor;
        return $this;
    }

}