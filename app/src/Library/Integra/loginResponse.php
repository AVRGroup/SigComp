<?php

namespace App\Library\Integra;

class loginResponse
{

    /**
     * @var wsLoginResponse $return
     */
    protected $return = null;


    public function __construct()
    {

    }

    /**
     * @return wsLoginResponse
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @param wsLoginResponse $return
     * @return \App\Library\Integra\loginResponse
     */
    public function setReturn($return)
    {
        $this->return = $return;
        return $this;
    }

}
