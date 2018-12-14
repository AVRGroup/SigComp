<?php
/**
 * Created by PhpStorm.
 * User: Lidiane
 * Date: 20/11/2018
 * Time: 19:35
 */
namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Topico
 *
 * @ORM\Entity()
 * @ORM\Table(name="topico")
 */
class Topico implements ToIdArrayInterface
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
    protected $assunto;

    /**
     * @ORM\Column(type="string")
     */
    protected $data;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="topicos_usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="categoria_topicos")
     * @ORM\JoinColumn(name="categoria", referencedColumnName="id", nullable=false)
     */
    protected $categoria;

    /**
     * @ORM\OneToMany(targetEntity="Resposta", mappedBy="topico")
     * @ORM\JoinColumn(name="topico", referencedColumnName="id", nullable=false)
     */
    protected $respostas_topico;







    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
    }
}