<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model\Certificado
 *
 * @ORM\Entity()
 * @ORM\Table(name="certificado")
 */
class Certificado
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="certificados")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    protected $usuario;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $nome;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $nome_impresso;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $extensao;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $tipo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $valido;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $num_horas;

    /**
     * @ORM\Column(type="date", nullable=true)
     */

    protected $data_inicio;


    /**
     * @ORM\Column(type="date", nullable=true)
     */

    protected $data_fim;

    /**
     * @ORM\Column(type="date", nullable=true)
     */

    protected $data_inicio1;


    /**
     * @ORM\Column(type="date", nullable=true)
     */

    protected $data_fim1;

    /**
     * @ORM\Column(type="date", nullable=true)
     */

    protected $data_inicio2;


    /**
     * @ORM\Column(type="date", nullable=true)
     */

    protected $data_fim2;

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
     * @return Certificado
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     * @return Certificado
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
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
     * @param mixed $nome
     * @return Certificado
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomeImpresso()
    {
        return $this->nome_impresso;
    }

    /**
     * @param mixed $nome_impresso
     */
    public function setNomeImpresso($nome_impresso): void
    {
        $this->nome_impresso = $nome_impresso;
    }

    /**
     * @return mixed
     */
    public function getExtensao()
    {
        return $this->extensao;
    }

    /**
     * @param mixed $extensao
     * @return Certificado
     */
    public function setExtensao($extensao)
    {
        $this->extensao = $extensao;
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
     * @return Certificado
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValido()
    {
        return $this->valido;
    }

    /**
     * @param mixed $valido
     * @return Certificado
     */
    public function setValido($valido)
    {
        $this->valido = $valido;
        return $this;
    }
}