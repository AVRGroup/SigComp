<?php

namespace App\Library\Integra;

class isValidTokenResponse
{

    /**
     * @var boolean $return
     */
    protected $return = null;

    /**
     * @param boolean $return
     */
    public function __construct($return)
    {
        $this->return = $return;
    }

    /**
     * @return boolean
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @param boolean $return
     * @return \App\Library\Integra\isValidTokenResponse
     */
    public function setReturn($return)
    {
        $this->return = $return;
        return $this;
    }

}
