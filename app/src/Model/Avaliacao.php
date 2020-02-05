<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;

/**
 * Model\Avaliacao
 *
 * @ORM\Entity()
 * @ORM\Table(name="avaliacao", uniqueConstraints={@UniqueConstraint(name="unique_avaliacao", columns={"aluno", "turma", "questionario"})})
 */
class Avaliacao  
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    protected $data;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="avaliacoes_aluno")
     * @ORM\JoinColumn(name="aluno", referencedColumnName="id", nullable=false)
     */
    protected $aluno;

    /**
     * @ORM\ManyToOne(targetEntity="Turma", inversedBy="avaliacoes_turma")
     * @ORM\JoinColumn(name="turma", referencedColumnName="id", nullable=false)
     */
    protected $turma;

    /**
     * @ORM\ManyToOne(targetEntity="Questionario", inversedBy="avaliacoes_questionario")
     * @ORM\JoinColumn(name="questionario", referencedColumnName="id", nullable=false)
     */
    protected $questionario;

    /**
     * @ORM\OneToMany(targetEntity="RespostaAvaliacao", mappedBy="avaliacao")
     * @ORM\JoinColumn(name="avaliacao", referencedColumnName="id", nullable=false)
     */
    protected $resposta_avaliacao;

    public function __construct()
    {
        $this->aluno = new ArrayCollection();
        $this->turma = new ArrayCollection();
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
     * @return Avaliacao
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return Avaliacao
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

}