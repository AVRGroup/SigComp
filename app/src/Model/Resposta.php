<?php
/**
 * Created by PhpStorm.
 * User: Lidiane
 * Date: 20/11/2018
 * Time: 19:44
 */
namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Resposta
 *
 * @ORM\Entity()
 * @ORM\Table(name="resposta")
 */
class Resposta implements ToIdArrayInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $conteudo;

    /**
     * @ORM\Column(type="string")
     */
    protected $data;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="respostas_usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Topico", inversedBy="respostas_topico")
     * @ORM\JoinColumn(name="topico", referencedColumnName="id", nullable=false)
     */
    protected $topico;



    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
    }
}