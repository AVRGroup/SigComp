<?php

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Usuario
 *
 * @ORM\Entity()
 * @ORM\Table(name="usuario")
 */
class Usuario implements ToIdArrayInterface
{

    const ALUNO = 0;

    const PROFESSOR = 1;

    const ADMIN = 2;

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
    protected $nome_abreviado;


    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $curso;

    /**
     * @ORM\Column(type="string", length=20, unique=true, nullable=true)
     */
    protected $matricula;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $grade;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $foto;

    /**
     * 0: Aluno
     * 1: Administrador
     * 2: Coordenador
     * 3: Bolsista
     *
     * @ORM\Column(type="smallint", options={"default" : 0})
     */
    protected $tipo = 0;

    /**
     * 0: Ativo
     * 1: Formado
     * 2: Outros
     *
     * @ORM\Column(type="smallint", options={"default" : 0})
     */
    protected $situacao = 0;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $ira;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     */
    protected $ira_periodo_passado;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     */
    protected $nivel = 1;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    protected $experiencia = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    protected $inteligencia = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    protected $sabedoria = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    protected $destreza = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    protected $forca = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    protected $carisma = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    protected $cultura = 0;

    /**
     * @ORM\OneToMany(targetEntity="Certificado", mappedBy="usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=true)
     */
    protected $certificados;

    /**
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $notas;

    /**
     * @ORM\OneToMany(targetEntity="MedalhaUsuario", mappedBy="usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=true)
     */
    protected $medalhas_usuario;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 1})
     */
    protected $nome_real;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : null})
     */
    protected $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : null})
     */
    protected $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : null})
     */
    protected $linkedin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : null})
     */
    protected $lattes;

    /**
     * @ORM\Column(type="string", length=50, nullable=true, options={"default" : null})
     */
    protected $sobre_mim;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 1})
     */
    protected $primeiro_login;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    protected $quantidade_acessos;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    protected $atualizado_ultima_carga;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $password;

    public function __construct()
    {
        $this->certificados = new ArrayCollection();
        $this->notas = new ArrayCollection();
    }

    public function setAtualizadoUltimaCarga($foiAtualizado)
    {
        $this->atualizado_ultima_carga = $foiAtualizado;
    }

    public function getAtualizadoUltimaCarga()
    {
        return $this->atualizado_ultima_carga;
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
     * @return Usuario
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return mixed
     */
    public function getPrimeiroNome()
    {
        $part = explode(' ', $this->getNome());
        return $part[0];
    }

    /**
     * @param mixed $nome
     * @return Usuario
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomeAbreviado()
    {
        return $this->nome_abreviado;
    }

    /**
     * @param mixed $nome_abreviado
     * @return Usuario
     */
    public function setNomeAbreviado($nome_abreviado)
    {
        $this->nome_abreviado = $nome_abreviado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param mixed $curso
     * @return Usuario
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * @param mixed $matricula
     * @return Usuario
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param mixed $grade
     * @return Usuario
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param mixed $foto
     * @return Usuario
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
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
     * @return Usuario
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIra()
    {
        return $this->ira;
    }

    /**
     * @param mixed $ira
     * @return Usuario
     */
    public function setIra($ira)
    {
        $this->ira = $ira;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getIraPeriodoPassado()
    {
        return $this->ira_periodo_passado;
    }

    /**
     * @param mixed $ira_periodo_passado
     * @return Usuario
     */
    public function setIraPeriodoPassado($ira_periodo_passado)
    {
        $this->ira_periodo_passado = $ira_periodo_passado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     * @return Usuario
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExperiencia()
    {
        return $this->experiencia;
    }

    /**
     * @param mixed $experiencia
     * @return Usuario
     */
    public function setExperiencia($experiencia)
    {
        $this->experiencia = $experiencia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInteligencia()
    {
        return $this->inteligencia;
    }

    /**
     * @param mixed $inteligencia
     * @return Usuario
     */
    public function setInteligencia($inteligencia)
    {
        $this->inteligencia = $inteligencia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSabedoria()
    {
        return $this->sabedoria;
    }

    /**
     * @param mixed $sabedoria
     * @return Usuario
     */
    public function setSabedoria($sabedoria)
    {
        $this->sabedoria = $sabedoria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDestreza()
    {
        return $this->destreza;
    }

    /**
     * @param mixed $destreza
     * @return Usuario
     */
    public function setDestreza($destreza)
    {
        $this->destreza = $destreza;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getForca()
    {
        return $this->forca;
    }

    /**
     * @param mixed $forca
     * @return Usuario
     */
    public function setForca($forca)
    {
        $this->forca = $forca;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCarisma()
    {
        return $this->carisma;
    }

    /**
     * @param mixed $carisma
     * @return Usuario
     */
    public function setCarisma($carisma)
    {
        $this->carisma = $carisma;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCultura()
    {
        return $this->cultura;
    }

    /**
     * @param mixed $cultura
     * @return Usuario
     */
    public function setCultura($cultura)
    {
        $this->cultura = $cultura;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCertificados()
    {
        return $this->certificados;
    }

    /**
     * @param mixed $certificados
     * @return Usuario
     */
    public function setCertificados($certificados)
    {
        $this->certificados = $certificados;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * @param mixed $notas
     * @return Usuario
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;
        return $this;
    }

    /**
     * @param Nota $nota
     * @return Usuario
     */
    public function addNota(Nota $nota)
    {
        $this->notas[] = $nota;
        $nota->setUsuario($this);

        return $this;
    }

    /**
     * @param Nota $nota
     * @return Usuario
     */
    public function removeNota(Nota $nota)
    {
        $this->notas->removeElement($nota);

        return $this;
    }

    public function getIdentifier()
    {
        return $this->getMatricula();
    }

    public function getNomeReal()
    {
        return $this->nome_real;
    }

    /**
     * @param mixed $nome_real
     */
    public function setNomeReal($nome_real): void
    {
        $this->nome_real = $nome_real;
    }


    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook): void
    {
        $this->facebook = $facebook;
    }

    /**
     * @param mixed $instagram
     */
    public function setInstagram($instagram): void
    {
        $this->instagram = $instagram;
    }

    /**
     * @param mixed $lattes
     */
    public function setLattes($lattes): void
    {
        $this->lattes = $lattes;
    }

    /**
     * @param mixed $linkedin
     */
    public function setLinkedin($linkedin): void
    {
        $this->linkedin = $linkedin;
    }

    public function getInstagram()
    {
        return $this->instagram;
    }


    public function getLinkedin()
    {
        return $this->linkedin;
    }


    public function getLattes()
    {
        return $this->lattes;
    }

    /**
     * @return mixed
     */
    public function getMedalhas()
    {
        return $this->medalhas_usuario;
    }

    /**
     * @param mixed $situacao
     * @return Usuario
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @return mixed
     */
    public function getSobreMim()
    {
        return $this->sobre_mim;
    }

    /**
     * @param mixed $sobre_mim
     */
    public function setSobreMim($sobre_mim): void
    {
        $this->sobre_mim = $sobre_mim;
    }

    /**
     * @return mixed
     */
    public function getMedalhasUsuario()
    {
        return $this->medalhas_usuario;
    }

    /**
     * @return mixed
     */
    public function getPrimeiroLogin()
    {
        return $this->primeiro_login;
    }

    /**
     * @param mixed $primeiro_login
     */
    public function setPrimeiroLogin($primeiro_login): void
    {
        $this->primeiro_login = $primeiro_login;
    }

    public function getQuantidadeAcessos()
    {
        return $this->quantidade_acessos;
    }

    /**
     * @param mixed $quantidade_acessos
     */
    public function setQuantidadeAcessos($quantidade_acessos): void
    {
        $this->quantidade_acessos = $quantidade_acessos;
    }

    /**
     * @param mixed $medalhas_usuario
     */
    public function setMedalhasUsuario($medalhas_usuario): void
    {
        $this->medalhas_usuario = $medalhas_usuario;
    }

    public function isAluno(){
        if($this->getTipo() == 0){
            return true;
        }

        return false;
    }

    public function isAdmin(){
        if($this->getTipo() == 1){
            return true;
        }

        return false;
    }

    public function isCoordenador(){
        if($this->getTipo() == 2){
            return true;
        }

        return false;
    }

    public function isBolsista(){
        if($this->getTipo() == 3){
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }



}