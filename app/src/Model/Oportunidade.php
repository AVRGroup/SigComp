<?php

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Oportunidade
 *
 * @ORM\Entity()
 * @ORM\Table(name="oportunidade")
 */
class Oportunidade
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $tipo;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $quantidade_vagas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $professor;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $remuneracao;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    protected $descricao;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $validade;


    /**
     * @ORM\OneToMany(targetEntity="OportunidadeDisciplina", mappedBy="oportunidade")
     * @ORM\JoinColumn(name="oportunidade", referencedColumnName="id", nullable=false)
     */
    protected $oportunidade_disciplina;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getQuantidadeVagas()
    {
        return $this->quantidade_vagas;
    }

    /**
     * @param mixed $quantidade_vagas
     */
    public function setQuantidadeVagas($quantidade_vagas): void
    {
        $this->quantidade_vagas = $quantidade_vagas;
    }

    /**
     * @return mixed
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * @param mixed $professor
     */
    public function setProfessor($professor): void
    {
        $this->professor = $professor;
    }

    /**
     * @return mixed
     */
    public function getValidade()
    {
        return $this->validade;
    }

    /**
     * @param mixed $validade
     */
    public function setValidade($validade): void
    {
        $this->validade = $validade;
    }


    /**
     * @return mixed
     */
    public function getRemuneracao()
    {
        return $this->remuneracao;
    }

    /**
     * @param mixed $remuneracao
     */
    public function setRemuneracao($remuneracao): void
    {
        $this->remuneracao = $remuneracao;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getNomeTipo()
    {
        switch ($this->tipo) {
            case 0:
                return "Iniciação Científica";
                break;
            case 1:
                return "Treinamento Profissional" ;
                break;
            case 2:
                return "Estágio";
                break;
            default:
                return "Oportunidade";
        }
    }

    public function abreviacao()
    {
        switch ($this->tipo) {
            case 0:
                return "ic";
                break;
            case 1:
                return "tp" ;
                break;
            case 2:
                return "estagio";
                break;
            default:
                return "outro";
        }
    }
}

