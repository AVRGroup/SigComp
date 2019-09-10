<?php

namespace App\Library\Integra;

class wsLoginResponse
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $token
     */
    protected $token = null;


    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \App\Library\Integra\wsLoginResponse
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return \App\Library\Integra\wsLoginResponse
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

}
