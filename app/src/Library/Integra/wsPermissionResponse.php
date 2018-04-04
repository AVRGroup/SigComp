<?php

namespace App\Library\Integra;

class wsPermissionResponse
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string[] $permission
     */
    protected $permission = null;


    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \App\Library\Integra\wsPermissionResponse
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param string[] $permission
     * @return \App\Library\Integra\wsPermissionResponse
     */
    public function setPermission(array $permission = null)
    {
        $this->permission = $permission;
        return $this;
    }

}
