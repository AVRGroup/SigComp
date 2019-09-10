<?php

namespace App\Library\Integra;

class wsUserInfoResponse
{

    /**
     * @var string $cpf
     */
    protected $cpf = null;

    /**
     * @var string $emailIntegra
     */
    protected $emailIntegra = null;

    /**
     * @var string $emailSiga
     */
    protected $emailSiga = null;

    /**
     * @var int $idPessoa
     */
    protected $idPessoa = null;

    /**
     * @var string $nome
     */
    protected $nome = null;

    /**
     * @var profileResponse $profileList
     */
    protected $profileList = null;

    /**
     * @var string $token
     */
    protected $token = null;

    /**
     * @var \DateTime $tokenTimeout
     */
    protected $tokenTimeout = null;

    /**
     * @param int $idPessoa
     */
    public function __construct($idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return \App\Library\Integra\wsUserInfoResponse
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailIntegra()
    {
        return $this->emailIntegra;
    }

    /**
     * @param string $emailIntegra
     * @return \App\Library\Integra\wsUserInfoResponse
     */
    public function setEmailIntegra($emailIntegra)
    {
        $this->emailIntegra = $emailIntegra;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailSiga()
    {
        return $this->emailSiga;
    }

    /**
     * @param string $emailSiga
     * @return \App\Library\Integra\wsUserInfoResponse
     */
    public function setEmailSiga($emailSiga)
    {
        $this->emailSiga = $emailSiga;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdPessoa()
    {
        return $this->idPessoa;
    }

    /**
     * @param int $idPessoa
     * @return \App\Library\Integra\wsUserInfoResponse
     */
    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return \App\Library\Integra\wsUserInfoResponse
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return profileResponse
     */
    public function getProfileList()
    {
        return $this->profileList;
    }

    /**
     * @param profileResponse $profileList
     * @return \App\Library\Integra\wsUserInfoResponse
     */
    public function setProfileList($profileList)
    {
        $this->profileList = $profileList;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return \App\Library\Integra\wsUserInfoResponse
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTokenTimeout()
    {
        if ($this->tokenTimeout == null) {
            return null;
        } else {
            try {
                return new \DateTime($this->tokenTimeout);
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    /**
     * @param \DateTime $tokenTimeout
     * @return \App\Library\Integra\wsUserInfoResponse
     */
    public function setTokenTimeout(\DateTime $tokenTimeout = null)
    {
        if ($tokenTimeout == null) {
            $this->tokenTimeout = null;
        } else {
            $this->tokenTimeout = $tokenTimeout->format(\DateTime::ATOM);
        }
        return $this;
    }

}
