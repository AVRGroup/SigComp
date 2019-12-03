<?php

/**
 * Essa tabela indica em qual grupo uma disciplina pertence. Esses grupos são usados para definir o radar chart ta
 * tela inicial
 */

namespace App\Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Model\Grupo
 *
 * @ORM\Entity()
 * @ORM\Table(name="grupo")
 */


class Grupo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $nome;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $curso;

}