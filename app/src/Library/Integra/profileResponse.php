<?php

namespace App\Library\Integra;

class profileResponse
{

    /**
     * @var profile[] $profile
     */
    protected $profile = null;


    public function __construct()
    {

    }

    /**
     * @return profile[]
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param profile[] $profile
     * @return \App\Library\Integra\profileResponse
     */
    public function setProfile(array $profile = null)
    {
        $this->profile = $profile;
        return $this;
    }

}
