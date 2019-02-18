<?php

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Amizade
 *
 * @ORM\Entity()
 * @ORM\Table(name="amizade")
 */

class Amizade implements toIdArrayInterface{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="amizade")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    protected $usuario_id;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="amizade")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    protected $amigo_id;

    /**
     * @ORM\Column(type="enum")
     */
    protected $estado;

    public function __construct()
    {
        $this->notas = new ArrayCollection();
    }


    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
    }
}