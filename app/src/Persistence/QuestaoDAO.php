<?php

namespace App\Persistence;

use Doctrine\ORM\EntityManager;
use App\Model\Questao;

class QuestaoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @return Questao[]|null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questao AS q");
            $questoes = $query->getResult();
        } catch (\Exception $e) {
            $questoes = null;
        }

        return $questoes;
    }

    /**
     * @param $id
     * @return Questao|null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questao AS q WHERE q.id = :id");
            $query->setParameter('id', $id);
            $questao = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $questao = null;
        }

        return $questao;
    }


    /**
     * @param $tipo_questionario
     * @return Questao[] |null
     */
    public function getAllByTipoQuestionario($tipo_questionario)
    {
        try {
            $query = $this->em->createQuery("SELECT q FROM App\Model\Questao AS q WHERE q.tipo_questionario = :tipo_questionario");
            $query->setParameter('tipo_questionario', $tipo_questionario);
            $questoes = $query->getResult();
        } catch (\Exception $e) {
            $questoes = null;
        }
        return $questoes;
    }
}