<?php

namespace App\Library\Integra;

class isValidToken
{

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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return \App\Library\Integra\isValidToken
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

}
