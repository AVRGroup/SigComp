<?php

namespace App\Persistence;

use App\Model\GradeDisciplina;
use Doctrine\ORM\EntityManager;
use PhpOffice\PhpSpreadsheet\Exception;

class GrupoDisciplinaCursoDAO extends BaseDAO
{

    public function __construct(EntityManager $db)
    {
        $this->em = $db;
    }
    
    public function getGrupoByDisciplinaCurso($disciplina, $curso)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\GrupoDisciplinaCurso AS g WHERE g.curso=:curso AND g.disciplina=:disciplina");
            $query->setParameter('curso', $curso);
            $query->setParameter('disciplina', $disciplina);
            $gdc = $query->getResult();

            if (!isset($gdc[0])) {
                return null;
            }

            $gdc = $gdc[0];

            $queryGrupo = $this->em->createQuery("SELECT g FROM App\Model\Grupo AS g WHERE g.id = :grupo");
            $queryGrupo->setParameter('grupo', $gdc->getGrupo());
            $grupo = $queryGrupo->getResult();

        } catch (\Exception $e) {
            $grupo = null;
        }

        return $grupo;
    }

    public function getByDisciplinaCurso($disciplina, $curso)
    {
        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\GrupoDisciplinaCurso AS g WHERE g.curso=:curso AND g.disciplina=:disciplina");
            $query->setParameter('curso', $curso);
            $query->setParameter('disciplina', $disciplina);
            $gdc = $query->getResult();
        } catch (Exception $e) {
            return null;
        }

        return $gdc[0];
    }

    public function deleteByGrupoCurso($grupoId, $curso)
    {
        $sql = "DELETE FROM grupo_disciplina_curso WHERE grupo = $grupoId AND curso = '$curso'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }
}
