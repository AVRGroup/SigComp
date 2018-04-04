<?php

namespace App\Library\Integra;

class getTokenExpirationResponse
{

    /**
     * @var \DateTime $return
     */
    protected $return = null;


    public function __construct()
    {

    }

    /**
     * @return \DateTime
     */
    public function getReturn()
    {
        if ($this->return == null) {
            return null;
        } else {
            try {
                return new \DateTime($this->return);
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    /**
     * @param \DateTime $return
     * @return \App\Library\Integra\getTokenExpirationResponse
     */
    public function setReturn(\DateTime $return = null)
    {
        if ($return == null) {
            $this->return = null;
        } else {
            $this->return = $return->format(\DateTime::ATOM);
        }
        return $this;
    }

}
