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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getNome()
    {
        $nome = explode('-', $this->nome);

        if(isset($nome[1])) {
            return $nome[1];
        }

        return $nome[0];

    }

    public function getNomeInteiro()
    {
        return $this->nome;
    }


    public function getOrdem()
    {
        $nome = explode('-', $this->nome);

        return $nome[0];
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }


    /**
     * @return mixed
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param mixed $curso
     */
    public function setCurso($curso): void
    {
        $this->curso = $curso;
    }



}