<?php

namespace App\Library\Integra;

class loginByCurso
{

    /**
     * @var string $cpf
     */
    protected $cpf = null;

    /**
     * @var string $senha
     */
    protected $senha = null;

    /**
     * @var string $curso
     */
    protected $curso = null;

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
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return \App\Library\Integra\loginByCurso
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
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
     * @return \App\Library\Integra\loginByCurso
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param string $curso
     * @return \App\Library\Integra\loginByCurso
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;
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
     * @return \App\Library\Integra\loginByCurso
     */
    public function setAppToken($appToken)
    {
        $this->appToken = $appToken;
        return $this;
    }

}
