<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;

class RespostaAvaliacaoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    public function truncateTable(){
        $sql = "TRUNCATE TABLE db_gamificacao.resposta_avaliacao;";
        $stmt= $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

     /**
     * @param $professor_id, $turma_id, $avaliacao_id, $questoes, $respostas
     */
    public function gravarResposta($professor_turma, $avaliacao_id, $questoes, $respostas)
    {
        $i = 0;
        foreach ($questoes as $questao){
            $sql_insert = "INSERT INTO db_gamificacao.resposta_avaliacao (`professor_turma`, `avaliacao`, `questao`, `resposta`) VALUES ({$professor_turma}, {$avaliacao_id}, {$questao->getId()}, {$respostas[$i]})";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
            $i = $i + 1;
        }
    }

}