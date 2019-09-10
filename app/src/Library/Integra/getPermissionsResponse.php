<?php

namespace App\Library\Integra;

class getPermissionsResponse
{

    /**
     * @var wsPermissionResponse $return
     */
    protected $return = null;


    public function __construct()
    {

    }

    /**
     * @return wsPermissionResponse
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @param wsPermissionResponse $return
     * @return \App\Library\Integra\getPermissionsResponse
     */
    public function setReturn($return)
    {
        $this->return = $return;
        return $this;
    }

}
