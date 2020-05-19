<?php

namespace App\Cache\Proxies\__CG__\App\Model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Usuario extends \App\Model\Usuario implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Proxy\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'id', 'nome', 'nome_abreviado', 'curso', 'matricula', 'grade', 'email', 'foto', 'tipo', 'situacao', 'ira', 'ira_periodo_passado', 'nivel', 'experiencia', 'inteligencia', 'sabedoria', 'destreza', 'forca', 'carisma', 'cultura', 'certificados', 'notas', 'medalhas_usuario', 'nome_real', 'facebook', 'instagram', 'linkedin', 'lattes', 'sobre_mim', 'primeiro_login', 'quantidade_acessos', 'atualizado_ultima_carga', 'password', 'avaliacoes', 'avaliacoes_aluno', 'turmas_professor'];
        }

        return ['__isInitialized__', 'id', 'nome', 'nome_abreviado', 'curso', 'matricula', 'grade', 'email', 'foto', 'tipo', 'situacao', 'ira', 'ira_periodo_passado', 'nivel', 'experiencia', 'inteligencia', 'sabedoria', 'destreza', 'forca', 'carisma', 'cultura', 'certificados', 'notas', 'medalhas_usuario', 'nome_real', 'facebook', 'instagram', 'linkedin', 'lattes', 'sobre_mim', 'primeiro_login', 'quantidade_acessos', 'atualizado_ultima_carga', 'password', 'avaliacoes', 'avaliacoes_aluno', 'turmas_professor'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Usuario $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function setAtualizadoUltimaCarga($foiAtualizado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAtualizadoUltimaCarga', [$foiAtualizado]);

        return parent::setAtualizadoUltimaCarga($foiAtualizado);
    }

    /**
     * {@inheritDoc}
     */
    public function getAtualizadoUltimaCarga()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAtualizadoUltimaCarga', []);

        return parent::getAtualizadoUltimaCarga();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', [$id]);

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getNome()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNome', []);

        return parent::getNome();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrimeiroNome()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrimeiroNome', []);

        return parent::getPrimeiroNome();
    }

    /**
     * {@inheritDoc}
     */
    public function setNome($nome)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNome', [$nome]);

        return parent::setNome($nome);
    }

    /**
     * {@inheritDoc}
     */
    public function getNomeAbreviado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNomeAbreviado', []);

        return parent::getNomeAbreviado();
    }

    /**
     * {@inheritDoc}
     */
    public function setNomeAbreviado($nome_abreviado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNomeAbreviado', [$nome_abreviado]);

        return parent::setNomeAbreviado($nome_abreviado);
    }

    /**
     * {@inheritDoc}
     */
    public function getCurso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCurso', []);

        return parent::getCurso();
    }

    /**
     * {@inheritDoc}
     */
    public function setCurso($curso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCurso', [$curso]);

        return parent::setCurso($curso);
    }

    /**
     * {@inheritDoc}
     */
    public function getMatricula()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMatricula', []);

        return parent::getMatricula();
    }

    /**
     * {@inheritDoc}
     */
    public function setMatricula($matricula)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMatricula', [$matricula]);

        return parent::setMatricula($matricula);
    }

    /**
     * {@inheritDoc}
     */
    public function getGrade()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGrade', []);

        return parent::getGrade();
    }

    /**
     * {@inheritDoc}
     */
    public function setGrade($grade)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGrade', [$grade]);

        return parent::setGrade($grade);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmail', []);

        return parent::getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmail', [$email]);

        return parent::setEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function getFoto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFoto', []);

        return parent::getFoto();
    }

    /**
     * {@inheritDoc}
     */
    public function setFoto($foto)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFoto', [$foto]);

        return parent::setFoto($foto);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipo', []);

        return parent::getTipo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipo($tipo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipo', [$tipo]);

        return parent::setTipo($tipo);
    }

    /**
     * {@inheritDoc}
     */
    public function getIra()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIra', []);

        return parent::getIra();
    }

    /**
     * {@inheritDoc}
     */
    public function setIra($ira)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIra', [$ira]);

        return parent::setIra($ira);
    }

    /**
     * {@inheritDoc}
     */
    public function getIraPeriodoPassado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIraPeriodoPassado', []);

        return parent::getIraPeriodoPassado();
    }

    /**
     * {@inheritDoc}
     */
    public function setIraPeriodoPassado($ira_periodo_passado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIraPeriodoPassado', [$ira_periodo_passado]);

        return parent::setIraPeriodoPassado($ira_periodo_passado);
    }

    /**
     * {@inheritDoc}
     */
    public function getNivel()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNivel', []);

        return parent::getNivel();
    }

    /**
     * {@inheritDoc}
     */
    public function setNivel($nivel)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNivel', [$nivel]);

        return parent::setNivel($nivel);
    }

    /**
     * {@inheritDoc}
     */
    public function getExperiencia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExperiencia', []);

        return parent::getExperiencia();
    }

    /**
     * {@inheritDoc}
     */
    public function setExperiencia($experiencia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExperiencia', [$experiencia]);

        return parent::setExperiencia($experiencia);
    }

    /**
     * {@inheritDoc}
     */
    public function getInteligencia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInteligencia', []);

        return parent::getInteligencia();
    }

    /**
     * {@inheritDoc}
     */
    public function setInteligencia($inteligencia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInteligencia', [$inteligencia]);

        return parent::setInteligencia($inteligencia);
    }

    /**
     * {@inheritDoc}
     */
    public function getSabedoria()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSabedoria', []);

        return parent::getSabedoria();
    }

    /**
     * {@inheritDoc}
     */
    public function setSabedoria($sabedoria)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSabedoria', [$sabedoria]);

        return parent::setSabedoria($sabedoria);
    }

    /**
     * {@inheritDoc}
     */
    public function getDestreza()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDestreza', []);

        return parent::getDestreza();
    }

    /**
     * {@inheritDoc}
     */
    public function setDestreza($destreza)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDestreza', [$destreza]);

        return parent::setDestreza($destreza);
    }

    /**
     * {@inheritDoc}
     */
    public function getForca()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getForca', []);

        return parent::getForca();
    }

    /**
     * {@inheritDoc}
     */
    public function setForca($forca)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setForca', [$forca]);

        return parent::setForca($forca);
    }

    /**
     * {@inheritDoc}
     */
    public function getCarisma()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCarisma', []);

        return parent::getCarisma();
    }

    /**
     * {@inheritDoc}
     */
    public function setCarisma($carisma)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCarisma', [$carisma]);

        return parent::setCarisma($carisma);
    }

    /**
     * {@inheritDoc}
     */
    public function getCultura()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCultura', []);

        return parent::getCultura();
    }

    /**
     * {@inheritDoc}
     */
    public function setCultura($cultura)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCultura', [$cultura]);

        return parent::setCultura($cultura);
    }

    /**
     * {@inheritDoc}
     */
    public function getCertificados()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCertificados', []);

        return parent::getCertificados();
    }

    /**
     * {@inheritDoc}
     */
    public function setCertificados($certificados)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCertificados', [$certificados]);

        return parent::setCertificados($certificados);
    }

    /**
     * {@inheritDoc}
     */
    public function getNotas()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotas', []);

        return parent::getNotas();
    }

    /**
     * {@inheritDoc}
     */
    public function setNotas($notas)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNotas', [$notas]);

        return parent::setNotas($notas);
    }

    /**
     * {@inheritDoc}
     */
    public function addNota(\App\Model\Nota $nota)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addNota', [$nota]);

        return parent::addNota($nota);
    }

    /**
     * {@inheritDoc}
     */
    public function removeNota(\App\Model\Nota $nota)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeNota', [$nota]);

        return parent::removeNota($nota);
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentifier()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdentifier', []);

        return parent::getIdentifier();
    }

    /**
     * {@inheritDoc}
     */
    public function getNomeReal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNomeReal', []);

        return parent::getNomeReal();
    }

    /**
     * {@inheritDoc}
     */
    public function setNomeReal($nome_real): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNomeReal', [$nome_real]);

        parent::setNomeReal($nome_real);
    }

    /**
     * {@inheritDoc}
     */
    public function getFacebook()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFacebook', []);

        return parent::getFacebook();
    }

    /**
     * {@inheritDoc}
     */
    public function setFacebook($facebook): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFacebook', [$facebook]);

        parent::setFacebook($facebook);
    }

    /**
     * {@inheritDoc}
     */
    public function setInstagram($instagram): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInstagram', [$instagram]);

        parent::setInstagram($instagram);
    }

    /**
     * {@inheritDoc}
     */
    public function setLattes($lattes): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLattes', [$lattes]);

        parent::setLattes($lattes);
    }

    /**
     * {@inheritDoc}
     */
    public function setLinkedin($linkedin): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLinkedin', [$linkedin]);

        parent::setLinkedin($linkedin);
    }

    /**
     * {@inheritDoc}
     */
    public function getInstagram()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInstagram', []);

        return parent::getInstagram();
    }

    /**
     * {@inheritDoc}
     */
    public function getLinkedin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLinkedin', []);

        return parent::getLinkedin();
    }

    /**
     * {@inheritDoc}
     */
    public function getLattes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLattes', []);

        return parent::getLattes();
    }

    /**
     * {@inheritDoc}
     */
    public function getMedalhas()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMedalhas', []);

        return parent::getMedalhas();
    }

    /**
     * {@inheritDoc}
     */
    public function setSituacao($situacao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSituacao', [$situacao]);

        return parent::setSituacao($situacao);
    }

    /**
     * {@inheritDoc}
     */
    public function getSituacao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSituacao', []);

        return parent::getSituacao();
    }

    /**
     * {@inheritDoc}
     */
    public function getSobreMim()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSobreMim', []);

        return parent::getSobreMim();
    }

    /**
     * {@inheritDoc}
     */
    public function setSobreMim($sobre_mim): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSobreMim', [$sobre_mim]);

        parent::setSobreMim($sobre_mim);
    }

    /**
     * {@inheritDoc}
     */
    public function getMedalhasUsuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMedalhasUsuario', []);

        return parent::getMedalhasUsuario();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrimeiroLogin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrimeiroLogin', []);

        return parent::getPrimeiroLogin();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrimeiroLogin($primeiro_login): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrimeiroLogin', [$primeiro_login]);

        parent::setPrimeiroLogin($primeiro_login);
    }

    /**
     * {@inheritDoc}
     */
    public function getQuantidadeAcessos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQuantidadeAcessos', []);

        return parent::getQuantidadeAcessos();
    }

    /**
     * {@inheritDoc}
     */
    public function setQuantidadeAcessos($quantidade_acessos): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setQuantidadeAcessos', [$quantidade_acessos]);

        parent::setQuantidadeAcessos($quantidade_acessos);
    }

    /**
     * {@inheritDoc}
     */
    public function setMedalhasUsuario($medalhas_usuario): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMedalhasUsuario', [$medalhas_usuario]);

        parent::setMedalhasUsuario($medalhas_usuario);
    }

    /**
     * {@inheritDoc}
     */
    public function isAluno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isAluno', []);

        return parent::isAluno();
    }

    /**
     * {@inheritDoc}
     */
    public function isAdmin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isAdmin', []);

        return parent::isAdmin();
    }

    /**
     * {@inheritDoc}
     */
    public function isCoordenador()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isCoordenador', []);

        return parent::isCoordenador();
    }

    /**
     * {@inheritDoc}
     */
    public function isBolsista()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isBolsista', []);

        return parent::isBolsista();
    }

    /**
     * {@inheritDoc}
     */
    public function isProfessor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isProfessor', []);

        return parent::isProfessor();
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPassword', []);

        return parent::getPassword();
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword($password): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPassword', [$password]);

        parent::setPassword($password);
    }

}
