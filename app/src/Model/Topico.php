<?php
/**
 * Created by PhpStorm.
 * User: Lidiane
 * Date: 20/11/2018
 * Time: 19:35
 */
namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Topico
 *
 * @ORM\Entity()
 * @ORM\Table(name="topico")
 */
class Topico implements ToIdArrayInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $assunto;

    /**
     * @ORM\Column(type="string", length=2000, nullable=false)
     */
    protected $conteudo;

    /**
     * @ORM\Column(type="string")
     */
    protected $data;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="topicos_usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="categoria_topicos")
     * @ORM\JoinColumn(name="categoria", referencedColumnName="id", nullable=false)
     */
    protected $categoria;

    /**
     * @ORM\OneToMany(targetEntity="Resposta", mappedBy="topico")
     * @ORM\JoinColumn(name="topico", referencedColumnName="id", nullable=false)
     */
    protected $respostas_topico;

    public function getIdentifier()
    {
        return $this->id;
    }

    public function setAssunto($assunto){
        $this->assunto = $assunto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function setUsuario($usuario){
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setCategoria($categoria){
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setResposta($resposta){
        $this->respostas_topico = $resposta;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRespostasTopico()
    {
        return $this->respostas_topico;
    }

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
    public function getConteudo()
    {
        return $this->conteudo;
    }

    /**
     * @param mixed $conteudo
     */
    public function setConteudo($conteudo): void
    {
        $this->conteudo = $conteudo;
    }


}