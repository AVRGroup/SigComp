<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model\RespostaAvaliacao
 *
 * @ORM\Entity()
 * @ORM\Table(name="resposta_avaliacao")
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
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="resposta_avaliacao")
     * @ORM\JoinColumn(name="professor", referencedColumnName="id", nullable=false)
     */
    protected $professor;

    /**
     * @ORM\ManyToOne(targetEntity="Turma", inversedBy="resposta_avaliacao")
     * @ORM\JoinColumn(name="turma", referencedColumnName="id", nullable=true)
     */
    protected $turma;

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