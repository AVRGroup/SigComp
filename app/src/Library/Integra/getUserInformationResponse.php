<?php

namespace App\Library\Integra;

class getUserInformationResponse
{

    /**
     * @var wsUserInfoResponse $return
     */
    protected $return = null;


    public function __construct()
    {

    }

    /**
     * @return wsUserInfoResponse
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @param wsUserInfoResponse $return
     * @return \App\Library\Integra\getUserInformationResponse
     */
    public function setReturn($return)
    {
        $this->return = $return;
        return $this;
    }

}
