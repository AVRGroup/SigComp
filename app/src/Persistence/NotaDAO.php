<?php

namespace App\Persistence;

use App\Model\Disciplina;
use Doctrine\ORM\EntityManager;

class NotaDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @param $notas
     */
    public function salvarNotas($notas){
        foreach($notas as $nota){
            $usuario = $nota->getUsuario()->getId();
            $disciplina = $nota->getDisciplina()->getId();
            $estado = $nota->getEstado();
            $valor = $nota->getValor();
            $periodo = $nota->getPeriodo();
            $sql_insert = "INSERT INTO db_gamificacao.nota (`usuario`, `disciplina`, `estado`, `valor`, `periodo`) VALUES ({$usuario}, {$disciplina}, {$estado}, {$valor}, {$periodo})";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        }
    }

}