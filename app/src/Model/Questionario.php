<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;

/**
 * Model\Questionario
 *
 * @ORM\Entity()
 * @ORM\Table(name="questionario", uniqueConstraints={@UniqueConstraint(name="unique_questionario", columns={"versao"})})
 */
class Questionario
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $versao;

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

}