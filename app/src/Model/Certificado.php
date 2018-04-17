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
     *  Tipos
     */
    const PART_PALESTRA = 0;
    const PART_MINICURSO = 1;
    const PART_MARATONA = 2;
    const APRE_MINICURSO = 3;
    const APRE_PALESTRA = 4;
    const PUBL_ARTIGO = 5;

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
    protected $extensao;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $tipo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $valido;


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

    static public function getAllTipos() {
        return [
            Certificado::PART_PALESTRA => 'Participação em Palestra',
            Certificado::PART_MINICURSO => 'Participação em Minicurso',
            Certificado::PART_MARATONA => 'Maratona de Programação',
            Certificado::APRE_MINICURSO => 'Apresentação de Minicurso',
            Certificado::APRE_PALESTRA => 'Apresentação de Palestra',
            Certificado::PUBL_ARTIGO => 'Publicação de Artigo'
        ];
    }

    public function getNomeTipo() {
        return Certificado::getAllTipos()[$this->getTipo()];
    }

    public function isInReview() {
        return is_null($this->getValido());
    }

}