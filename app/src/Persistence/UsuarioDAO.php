<?php

namespace App\Persistence;

use App\Model\Disciplina;
use App\Model\Medalha;
use App\Model\Usuario;
use Doctrine\ORM\EntityManager;

class UsuarioDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    /**
     * @param $id
     * @return Usuario|null
     */
    public function getById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.id = :id");
            $query->setParameter('id', $id);
            $usuario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $usuario = null;
        }

        return $usuario;
    }

    /**
     * @param $id
     * @return Usuario|null
     */
    public function getByIdFetched($id)
    {
        try {
            $query = $this->em->createQuery("SELECT u,c,n, nd FROM App\Model\Usuario AS u LEFT JOIN u.certificados AS c LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd WHERE u.id = :id ORDER BY n.periodo ASC, c.valido ASC");
            $query->setParameter('id', $id);
            $usuario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $usuario = null;
        }

        return $usuario;
    }

    /**
\     * @return Usuario[]|null
     */
    public function getAllFetched()
    {
        try {
            $query = $this->em->createQuery("SELECT u,c,n, nd FROM App\Model\Usuario AS u LEFT JOIN u.certificados AS c LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd ORDER BY n.periodo ASC");
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    /**
     * @param array $matriculas
     * @return Usuario[]
     */
    public function getByMatricula(array $matriculas)
    {
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.matricula IN (:matriculas)");
            $query->setParameter('matriculas', $matriculas);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = [];
        }

        return $usuarios;
    }

    /**
     * @return Usuario[] |null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u");
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    public function getTop10Ira(){
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u ORDER BY u.ira DESC")->setMaxResults(10);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    public function getPeriodo($periodo, $qtdeDisciplinaPeriodo){
        $sql = "Select usuario from (Select usuario, count(id) as aprovadas_periodo from db_gamificacao.nota where estado = 'Aprovado' and disciplina in (Select disciplina from db_gamificacao.grade_disciplina where grade = 1 AND periodo = {$periodo}) group by usuario) as test where test.aprovadas_periodo = {$qtdeDisciplinaPeriodo}";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }

    public function setPeriodo($results, $periodo){
        foreach ($results as $user){
            $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$user['usuario']}', {$periodo})";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        }
    }


    public function getMedalsByIdFetched($id)
    {
        $sql = "SELECT medalha, medalha.nome, imagem FROM usuario left join medalha_usuario on usuario.id = medalha_usuario.usuario left join medalha on medalha = medalha.id WHERE usuario.id = '{$id}'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }
}
