<?php

namespace App\Library\Integra;

class loginByMatricula
{

    /**
     * @var string $matricula
     */
    protected $matricula = null;

    /**
     * @var string $senha
     */
    protected $senha = null;

    /**
     * @var string $appToken
     */
    protected $appToken = null;


    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * @param string $matricula
     * @return \App\Library\Integra\loginByMatricula
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     * @return \App\Library\Integra\loginByMatricula
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppToken()
    {
        return $this->appToken;
    }

    /**
     * @param string $appToken
     * @return \App\Library\Integra\loginByMatricula
     */
    public function setAppToken($appToken)
    {
        $this->appToken = $appToken;
        return $this;
    }

}
