<?php
/**
 * Created by PhpStorm.
 * User: Lidiane
 * Date: 20/11/2018
 * Time: 19:46
 */

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Categoria
 *
 * @ORM\Entity()
 * @ORM\Table(name="categoria")
 */
class Categoria implements ToIdArrayInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $nome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $descricao;

    /**
     * @ORM\OneToMany(targetEntity="Topico", mappedBy="categoria")
     * @ORM\JoinColumn(name="categoria", referencedColumnName="id", nullable=false)
     */
    protected $categoria_topicos;

    /**
     * @param mixed $nome
     * @return Categoria
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $descricao
     * @return Categoria
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getIdentifier()
    {
        return $this->id;
    }
}