<?php

namespace App\Library\Integra;

class isValidProfile
{

    /**
     * @var string $token
     */
    protected $token = null;

    /**
     * @var string $profile
     */
    protected $profile = null;


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
     * @return \App\Library\Integra\isValidProfile
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     * @return \App\Library\Integra\isValidProfile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
        return $this;
    }

}
