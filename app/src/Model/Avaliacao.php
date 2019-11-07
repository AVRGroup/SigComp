<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Model\Avaliacao
 *
 * @ORM\Entity()
 * @ORM\Table(name="avaliacao")
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
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="avaliacao")
     * @ORM\JoinTable(name="aluno_avaliacao")
     */
    protected $alunos;

    public function __construct()
    {
        $this->alunos = new ArrayCollection();
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