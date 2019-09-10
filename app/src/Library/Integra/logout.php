<?php

namespace App\Library\Integra;

class logout
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
     * @return \App\Library\Integra\logout
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

}
