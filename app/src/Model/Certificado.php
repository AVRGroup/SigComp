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
    const ORG_PALESTRA = 6;
    const ORG_EVENTO = 7;
    const APRE_EVENTO = 8;
    const GRP_ESTUDO = 9;
    const ESTAGIO = 10;
    const GET = 11;
    const REPRESENTACAO = 12;
    const LING_ENTRANGEIRA = 13;
    const CERT_CURSO = 14;
    const EMP_JUNIOR = 15;
    const VIVENCIA = 16;
    const PART_EVENTO = 17;
    const MONITORIA = 18;
    const TP = 19;
    const IC = 20;
    const TA = 21;

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

    static public function getAllTipos() {
        return [
            Certificado::PART_PALESTRA => 'Participação em Palestra',
            Certificado::PART_MINICURSO => 'Participação em Minicurso',
            Certificado::PART_MARATONA => 'Maratona de Programação',
            Certificado::APRE_MINICURSO => 'Apresentação de Minicurso',
            Certificado::APRE_PALESTRA => 'Apresentação de Palestra',
            Certificado::PUBL_ARTIGO => 'Publicação de Artigo',
            Certificado::ORG_EVENTO => 'Organização de Evento',
            Certificado::APRE_EVENTO => 'Organizacao de Palestra',
            Certificado::GRP_ESTUDO => 'Grupo de Estudo',
            Certificado::ESTAGIO => 'Estágio',
            Certificado::GET => 'Grupo de Educação Tutorial (GET)',
            Certificado::REPRESENTACAO => 'Representação Estudantil',
            Certificado::LING_ENTRANGEIRA => 'Certificação em Língua Estrangeira',
            Certificado::CERT_CURSO => 'Certificação na área do curso (linguagem de programação, metodologias, outros)',
            Certificado::EMP_JUNIOR => 'Participação na administração de empresa júnior',
            Certificado::VIVENCIA => 'Vivência profissional complementar na área de formação do curso',
            Certificado::PART_EVENTO => 'Participação em eventos (congresso, seminários...)',
            Certificado::MONITORIA => 'Bolsa de Monitoria',
            Certificado::TP => 'Treinamento Profissional',
            Certificado::IC => 'Iniciação Científica',
            Certificado::TA => 'Treinamento Administrativo',

        ];
    }

    public function getNomeTipo() {
        return Certificado::getAllTipos()[$this->getTipo()];
    }

    public function isInReview() {
        return is_null($this->getValido());
    }

    /**
     * @return mixed
     */
    public function getNumHoras()
    {
        return $this->num_horas;
    }

    /**
     * @param mixed $num_horas
     */
    public function setNumHoras($num_horas): void
    {
        $this->num_horas = $num_horas;
    }

    /**
     * @return mixed
     */
    public function getDataFim()
    {
        return $this->data_fim;
    }

    /**
     * @return mixed
     */
    public function getDataInicio()
    {
        return $this->data_inicio;
    }

    /**
     * @param mixed $data_fim
     */
    public function setDataFim($data_fim): void
    {
        $this->data_fim = $data_fim;
    }

    /**
     * @param mixed $data_inicio
     */
    public function setDataInicio($data_inicio): void
    {
        $this->data_inicio = $data_inicio;
    }

    /**
     * @return mixed
     */
    public function getDataFim1()
    {
        return $this->data_fim1;
    }

    /**
     * @return mixed
     */
    public function getDataFim2()
    {
        return $this->data_fim2;
    }


    /**
     * @return mixed
     */
    public function getDataInicio1()
    {
        return $this->data_inicio1;
    }

    /**
     * @return mixed
     */
    public function getDataInicio2()
    {
        return $this->data_inicio2;
    }

    /**
     * @param mixed $data_fim1
     */
    public function setDataFim1($data_fim1): void
    {
        $this->data_fim1 = $data_fim1;
    }


    /**
     * @param mixed $data_fim2
     */
    public function setDataFim2($data_fim2): void
    {
        $this->data_fim2 = $data_fim2;
    }

    /**
     * @param mixed $data_inicio1
     */
    public function setDataInicio1($data_inicio1): void
    {
        $this->data_inicio1 = $data_inicio1;
    }

    /**
     * @param mixed $data_inicio2
     */
    public function setDataInicio2($data_inicio2): void
    {
        $this->data_inicio2 = $data_inicio2;
    }

}