<?php

namespace App\Library\Integra;

class profile
{

    /**
     * @var string $matricula
     */
    protected $matricula = null;

    /**
     * @var string $tipo
     */
    protected $tipo = null;


    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * @param string $matricula
     * @return \App\Library\Integra\profile
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     * @return \App\Library\Integra\profile
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

}
