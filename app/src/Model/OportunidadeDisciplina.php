<?php
namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model\OportunidadeDisciplina
 *
 * @ORM\Entity()
 * @ORM\Table(name="oportunidade_disciplina")
 */
class OportunidadeDisciplina
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Oportunidade", inversedBy="oportunidade_disciplina")
     * @ORM\JoinColumn(name="oportunidade", referencedColumnName="id", nullable=false)
     */
    protected $oportunidade;

    /**
     * @ORM\ManyToOne(targetEntity="Disciplina", inversedBy="oportunidade_disciplina")
     * @ORM\JoinColumn(name="disciplina", referencedColumnName="id", nullable=false)
     */
    protected $disciplina;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getOportunidade()
    {
        return $this->oportunidade;
    }

    /**
     * @param mixed $oportunidade
     */
    public function setOportunidade($oportunidade): void
    {
        $this->oportunidade = $oportunidade;
    }

    /**
     * @return mixed
     */
    public function getDisciplina()
    {
        return $this->disciplina;
    }

    /**
     * @param mixed $disciplina
     */
    public function setDisciplina($disciplina): void
    {
        $this->disciplina = $disciplina;
    }


}