<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;

/**
 * Model\QuestaoQuestionario
 *
 * @ORM\Entity()
 * @ORM\Table(name="questao_questionario", uniqueConstraints={@UniqueConstraint(name="unique_questao", columns={"questao", "questionario"})})
 */
class QuestaoQuestionario
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Questao", inversedBy="questionarios_questao")
     * @ORM\JoinColumn(name="questao", referencedColumnName="id", nullable=false)
     */
    protected $questao;

    /**
     * @ORM\ManyToOne(targetEntity="Questionario", inversedBy="questoes_questionario")
     * @ORM\JoinColumn(name="questionario", referencedColumnName="id", nullable=false)
     */
    protected $questionario;

     /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $numero;


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
     * @return QuestaoQuestionario
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Questao
     */
    public function getQuestao()
    {
        return $this->questao;
    }

    /**
     * @param mixed $questao
     * @return QuestaoQuestionario
     */
    public function setQuestao($questao)
    {
        $this->questao = $questao;
        return $this;
    }

    /**
     * @return Questionario
     */
    public function getQuestionario()
    {
        return $this->questionario;
    }

    /**
     * @param mixed $questionario
     * @return QuestaoQuestionario
     */
    public function setQuestionario($questionario)
    {
        $this->questionario = $questionario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     * @return QuestaoQuestionario
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }
}