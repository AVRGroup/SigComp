<?php

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Model\Questao
 *
 * @ORM\Entity()
 * @ORM\Table(name="questao")
 */
class Questao implements ToIdArrayInterface
{

    //Tipos de questionário
    const AVALIACAO_PESSOAL = 0;

    const AVALIACAO_TURMA = 1;

    const AVALIACAO_PROFESSOR = 2;

    //Tipos de questões
    const FECHADA = 0;

    const ABERTA = 1;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $numero;

    /**
     * @ORM\Column(type="string", length=300, nullable=false)
     */
    protected $enunciado;

    /**
     * 0: Avaliacao_Pessoal
     * 1: Avaliacao_Turma
     * 2: Avaliacao_Professor
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $tipo = 0;

    /**
     * 0: Fechada
     * 1: Aberta
     *
     * @ORM\Column(type="smallint", options={"default" : 0})
     */
    protected $tipo_questionario = 0;

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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     * @return Questao
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
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
    public function getTipoQuestionario()
    {
        return $this->tipo_questionario;
    }

    /**
     * @param mixed $tipo_questionario
     * @return Questao
     */
    public function setTipoQuestionario($tipo_questionario)
    {
        $this->tipo_questionario = $tipo_questionario;
        return $this;
    }

}