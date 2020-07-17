<?php


namespace App\Persistence;


use Doctrine\ORM\EntityManager;

class GrupoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }

    public function getGrupoById($id)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grupo AS g WHERE g.id = :id");
            $query->setParameter('id', $id);
            $grupo = $query->getResult();
        } catch (\Exception $e) {
            $grupo = null;
        }

        return $grupo;
    }

    public function getAllByCurso($curso)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grupo AS g WHERE g.curso = :curso");
            $query->setParameter('curso', $curso);
            $grupo = $query->getResult();
        } catch (\Exception $e) {
            $grupo = null;
        }

        return $grupo;
    }

    public function existsCourseWithGroup($curso)
    {
        try {
            $query = $this->em->createQuery("SELECT DISTINCT u.curso FROM App\Model\Grupo AS u");
            $cursos = $query->getResult();
        } catch (\Exception $e) {
           var_dump( $e->getMessage());
        }

        foreach( $cursos as $cur ){
            if( $cur['curso'] == $curso ){
                return true;
            }
        }
        return false;
    }

    /**
     * @return Grupo[]|null
     */
    public function getAll()
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grupo AS g");
            $grupos = $query->getResult();
        } catch (\Exception $e) {
            $grupos = null;
        }
        return $grupos;
    }

    public function getQuantidadeDeDisciplinasPorGrupoPorCurso($curso)
    {
        $sql = "SELECT grupo_id, COUNT(*) FROM disciplina GROUP_BY grupo_id";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }
}