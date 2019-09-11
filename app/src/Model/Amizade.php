<?php

namespace App\Model;
use Doctrine\ORM\Mapping as ORM;


/**
 * Model\Amizade
 *
 * @ORM\Entity()
 * @ORM\Table(name="amizade")
 */

class Amizade {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $usuario_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $amigo_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $estado;

    public function getIdentifier()
    {

    }
}