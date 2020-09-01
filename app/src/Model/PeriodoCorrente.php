<?php

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\PeriodoCorrente
 *
 * @ORM\Entity()
 * @ORM\Table(name="periodo_corrente")
 */
class PeriodoCorrente implements toIdArrayInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     */
    protected $ultima_carga;

    /**
     * @ORM\Column(type="integer")
     */
    protected $periodo_atual;

    public function getIdentifier()
    {
       return $this->id;
    }

    public function getUltimaCarga()
    {
        return $this->ultima_carga;
    }
}