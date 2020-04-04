<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;


/**
 * Model\Questao
 *
 * @ORM\Entity()
 * @ORM\Table(name="questao")
 */
class Questao
{
    //Tipos de questões
    const FECHADA = 0;

    const ABERTA = 1;

    //Categorias
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
     * @ORM\Column(type="string", length=300, nullable=false)
     */
    protected $enunciado;

    /**
     * 0: Fechada
     * 1: Sim_Nao
     * 2: Aberta
     *
     * @ORM\Column(type="smallint", options={"default" : 0})
     */
    protected $tipo = 0;

    /**
     * 0: Avaliacao_Pessoal
     * 1: Avaliacao_Turma
     * 2: Avaliacao_Professor
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $categoria = 0;

    /**
     * @ORM\OneToMany(targetEntity="RespostaAvaliacao", mappedBy="avaliacao")
     * @ORM\JoinColumn(name="avaliacao", referencedColumnName="id", nullable=false)
     */
    protected $resposta_avaliacao;

    /**
     * @ORM\OneToMany(targetEntity="QuestaoQuestionario", mappedBy="questao")
     * @ORM\JoinColumn(name="questao", referencedColumnName="id", nullable=false)
     */
    protected $questionarios_questao;

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
     * @return Questao
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnunciado()
    {
        return $this->enunciado;
    }

    /**
     * @param mixed $enunciado
     * @return Questao
     */
    public function setEnunciado($enunciado)
    {
        $this->enunciado = $enunciado;
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
     * @return Questao
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $tipo
     * @return Questao
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

}