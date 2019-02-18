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
    \     * @return Usuario[]|null
     */
    public function getAllFetched10PrimeirosPorIra()
    {
        try {
            $query = $this->em->createQuery("SELECT u,c,n, nd FROM App\Model\Usuario AS u LEFT JOIN u.certificados AS c LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd WHERE u.situacao = 0 ORDER BY u.ira DESC")->setMaxResults(500);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    public function getAllFetched10PrimeirosPorIraPeriodoPassado()
    {
        try {
            $query = $this->em->createQuery("SELECT u,c,n, nd FROM App\Model\Usuario AS u LEFT JOIN u.certificados AS c LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd WHERE u.situacao = 0 ORDER BY u.ira_periodo_passado DESC")->setMaxResults(500);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    public function getAllFetchedByPeriodoNota($periodo)
    {
        try {
            $query = $this->em->createQuery("SELECT u,c,n, nd FROM App\Model\Usuario AS u LEFT JOIN u.certificados AS c LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd WHERE n.periodo = :periodo ORDER BY n.periodo ASC");
            $query->setParameter('periodo', $periodo);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    /**
    \
     * @param $grade
     * @return Usuario[]|null
     */
    public function getUsersNotasByGrade($grade)
    {
        try {
            $query = $this->em->createQuery("SELECT u, n, nd FROM App\Model\Usuario AS u LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd WHERE u.grade = :grade AND (n.estado = 'Aprovado' OR n.estado = 'Dispensado')");
            $query->setParameter('grade', $grade);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }
        return $usuarios;
    }

    /**
     * @param $grade
     * @param $periodo
     * @return array
     */
    public function getDisciplinasByGradePeriodo($grade, $periodo)
    {
        switch ($grade){
            case 12009: $grade_num = 3;
                break;
            case 12014: $grade_num = 2;
                break;
            case 12018: $grade_num = 1;
                break;
        }
        try {
            $query = $this->em->createQuery("SELECT d FROM App\Model\Disciplina AS d LEFT JOIN d.disciplinas_grade AS dg WHERE dg.grade = :grade AND dg.periodo = :periodo");
            $query->setParameters(['grade' => $grade_num, 'periodo' => $periodo]);
            $disciplinas = $query->getResult();
        } catch (\Exception $e) {
            $disciplinas = null;
        }
        return $disciplinas;
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


    public function getByMatriculaNome($pesquisa){
        try {
            $query = $this->em->createQuery(" SELECT u FROM App\Model\Usuario AS u WHERE (u.matricula LIKE '%':pesquisa'%' OR u.nome LIKE '%':pesquisa'%') ");
            die(var_dump($query));
            $query->setParameter('pesquisa', $pesquisa);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = [];
        }

        return $usuarios;
    }


    public function getByMatriculaNomeARRAY($pesquisa){
        $sql = "SELECT * FROM usuario WHERE (usuario.matricula LIKE '%$pesquisa%' OR usuario.nome LIKE '%$pesquisa%')";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
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

    public function getAllARRAY()
    {
        $sql = "SELECT * FROM usuario";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getCountNaoLogaram()
    {
        $sql = "SELECT COUNT(*) FROM usuario WHERE usuario.primeiro_login = 1";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getCountLogaram()
    {
        $sql = "SELECT COUNT(*) FROM usuario WHERE usuario.primeiro_login = 0";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }


    public function getTop10IraTotal(){
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.situacao = :situacao ORDER BY u.ira DESC")->setMaxResults(10);
            $query->setParameter('situacao', 0);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    public function getTop10IraPeriodo(){
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.situacao = :situacao ORDER BY u.ira_periodo_passado DESC")->setMaxResults(10);
            $query->setParameter('situacao', 0);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    public function getPeriodo($periodo, $grade){
        switch ($grade){
            case 12009: $grade_num = 3;
                break;
            case 12014: $grade_num = 2;
                break;
            case 12018: $grade_num = 1;
                break;
        }
        $sql = "Select * from (Select usuario, count(id) as aprovadas_periodo from db_gamificacao.nota where (estado = 'Aprovado' or 'Dispensado') and disciplina in (Select disciplina from db_gamificacao.grade_disciplina where periodo = '{$periodo}' and grade = '{$grade_num}') group by usuario) as test left join ((SELECT id FROM db_gamificacao.usuario where grade = '{$grade}') as users) on test.usuario = users.id";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }

    public function setPeriodo($results, $periodo, $grade){
        foreach ($results as $user){
            //if($user->getGrade() == $grade){
                $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$user->getId()}', {$periodo})";
                $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                $stmt_insert->execute();
            //}
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

    public function getTodasMedalhas(){
        $sql = "SELECT * FROM medalha";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }

    public function getByIRA($ira_min, $ira_max){
        $ira_min = intval($ira_min);
        $ira_max = intval($ira_max);
        $sql = "SELECT id FROM usuario where (usuario.ira >= $ira_min AND usuario.ira < $ira_max)";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }

    public function setByIRA($results, $ira){
        switch ($ira){
            case 60: $medalha = 13;
                break;
            case 70: $medalha = 14;
                break;
            case 80: $medalha = 15;
                break;
        }
        foreach ($results as $user){
            $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$user['id']}','$medalha')";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        }
    }

    public function getByOptativas($qtde_min, $qtde_max, $grade){
        switch ($grade){
            case 12009: $grade_num = 3;
                break;
            case 12014: $grade_num = 2;
                break;
            case 12018: $grade_num = 1;
                break;
        }
        $qtde_min = intval($qtde_min);
        $qtde_max = intval($qtde_max);
        $sql = "Select * from (Select usuario, count(id) as aprovadas_periodo from db_gamificacao.nota where nota.estado = 'Aprovado' and nota.disciplina in (Select id from db_gamificacao.disciplina where disciplina.id not in (Select disciplina from db_gamificacao.grade_disciplina where grade = '{$grade_num}') and disciplina.codigo not like 'DCC%') group by usuario) as test left join usuario on test.usuario = usuario.id where (test.aprovadas_periodo >= $qtde_min AND test.aprovadas_periodo < $qtde_max)";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }

    public function setConviteAmizade($remetente, $destinatario){
        $sql = "INSERT INTO db_gamificacao.amizade (id_usuario, id_amigo, estado) VALUES ('$remetente', '$destinatario', 'pendente')";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    public function getConvitesPendentes($id){
        $sql = "SELECT usuario.id, usuario.nome FROM amizade JOIN usuario ON id_usuario = usuario.id WHERE amizade.estado = 'pendente' AND id_amigo = '$id'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }

    public function aceitarConvite($remetente, $destinatario){
        $sql = "ALTER TABLE db_gamificacao.amizade SET amizade.estado='aceito' WHERE amizade.id_amigo = '$destinatario' AND amizade.id_usuario = '$remetente'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    public function setByOptativas($results, $qtde, $grade){
        switch ($qtde){
            case 2: $medalha = 17;
                break;
            case 3: $medalha = 18;
                break;
            case 4: $medalha = 19;
                break;
        }
        foreach ($results as $user){
            if($user['grade'] == $grade) {
                $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$user['usuario']}', '$medalha')";
                $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                $stmt_insert->execute();
            }
        }
    }

    public function getByTipoCertificado($tipoCertificado){
        $sql = "SELECT usuario.id , certificado.num_horas FROM usuario JOIN certificado ON certificado.usuario = usuario.id WHERE certificado.tipo = '{$tipoCertificado}' AND num_horas >= 60 AND valido = 1";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();

        return $results;
    }

    public function setByNumMedalha($results, $numMedalha, $offset1 = 0){
        foreach ($results as $result){
            if($result['num_horas'] >= 60) {
                $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$result['id']}', '{$numMedalha}')";
                $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                $stmt_insert->execute();
            }

            if($result['num_horas'] >= 120){
                $numMedalha = $numMedalha + 1;
                $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$result['id']}', '{$numMedalha}')";
                $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                $stmt_insert->execute();
            }

            if($result['num_horas'] >= 180){
                $numMedalha = $numMedalha + 1;
                $numMedalha = $numMedalha + $offset1;
                $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$result['id']}', '{$numMedalha}')";
                $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                $stmt_insert->execute();
            }
        }
    }

    public function getBy100($qtde_min, $qtde_max, $grade){
        switch ($grade){
            case 12009: $grade_num = 3;
                break;
            case 12014: $grade_num = 2;
                break;
            case 12018: $grade_num = 1;
                break;
        }
        $qtde_min = intval($qtde_min);
        $qtde_max = intval($qtde_max);
        $sql = "Select * from (Select usuario, count(id) as aprovadas_periodo from db_gamificacao.nota where estado = 'Aprovado' and valor = 100 and disciplina in (Select disciplina from db_gamificacao.grade_disciplina where grade = '{$grade_num}') group by usuario) as test left join usuario on test.usuario = usuario.id where (test.aprovadas_periodo >= $qtde_min AND test.aprovadas_periodo < $qtde_max)";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }

    public function setBy100($results, $qtde, $grade){
        switch ($qtde){
            case 1: $medalha = 10;
                break;
            case 2: $medalha = 11;
                break;
            case 3: $medalha = 12;
                break;
        }
        foreach ($results as $user){
            if($user['grade'] == $grade){
                $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$user['usuario']}', '$medalha')";
                $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                $stmt_insert->execute();
            }
        }
    }

    public function getUsersPeriodo($periodo){
        $sql = "Select distinct u.id, u.nome from db_gamificacao.usuario  as u inner join db_gamificacao.nota on u.id = nota.usuario where nota.periodo = '$periodo'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function setActiveUsers($results){
        foreach ($results as $result) {
            $sql = "UPDATE db_gamificacao.usuario set usuario.situacao = 0 where usuario.id = '{$result['id']}'";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
        }
    }



}
