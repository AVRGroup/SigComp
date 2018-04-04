<?php

namespace App\Library\Integra;

class updateUserGroup
{

    /**
     * @var int $idUser
     */
    protected $idUser = null;

    /**
     * @var string $token
     */
    protected $token = null;

    /**
     * @param int $idUser
     */
    public function __construct($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     * @return \App\Library\Integra\updateUserGroup
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
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
     * @return \App\Library\Integra\updateUserGroup
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

}
