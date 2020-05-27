<?php

namespace App\Persistence;

use App\Library\Helper;
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

    public function getUserByLoginSenha($login, $senha)
    {
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.nome = :login AND u.password = :senha");
            $query->setParameter('login', $login);
            $query->setParameter('senha', $senha);
            $usuario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $usuario = null;
        }

        return $usuario;
    }

    public function getUsuarioLogado() : Usuario
    {
        $id = $_SESSION['id'];

        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.id = :id");
            $query->setParameter('id', $id);
            $usuario = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $usuario = null;
        }

        return $usuario;
    }


    public function getDisciplinasAprovadasById($idUsuario)
    {
        $sql = "SELECT disciplina FROM nota WHERE estado='Aprovado' AND usuario=$idUsuario";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
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
     * \     * @return Usuario[]|null
     * @param null $curso
     * @return mixed|null
     */
    public function getAllFetched10PrimeirosPorIra($curso = null)
    {
        $queryCurso = isset($curso) ? "AND u.curso = '$curso'" : "";

        try {
            $query = $this->em->createQuery("SELECT u,c,n, nd FROM App\Model\Usuario AS u LEFT JOIN u.certificados AS c LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd WHERE u.situacao = 0 $queryCurso ORDER BY u.ira DESC")->setMaxResults(500);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            $usuarios = null;
        }

        return $usuarios;
    }

    public function getAllFetched10PrimeirosPorIraPeriodoPassado($curso = null)
    {
        $queryCurso = isset($curso) ? "AND u.curso = '$curso'" : "";

        try {
            $query = $this->em->createQuery("SELECT u,c,n, nd FROM App\Model\Usuario AS u LEFT JOIN u.certificados AS c LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd WHERE u.situacao = 0 $queryCurso ORDER BY u.ira_periodo_passado DESC")->setMaxResults(500);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
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
     * \
     * @param $grade
     * @param $curso
     * @return Usuario[]|null
     */
    public function getUsersNotasByGrade($grade, $curso)
    {
        try {
            $query = $this->em->createQuery("SELECT u, n, nd FROM App\Model\Usuario AS u LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd WHERE u.grade = :grade AND u.curso = :curso AND (n.estado = 'Aprovado' OR n.estado = 'Dispensado')");
            $query->setParameter('grade', $grade);
            $query->setParameter('curso', $curso);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }
        return $usuarios;
    }

    public function getSingleUsersNotasByGrade($userId, $grade)
    {
        try {
            $query = $this->em->createQuery("SELECT u, n, nd FROM App\Model\Usuario AS u LEFT JOIN u.notas AS n LEFT JOIN n.disciplina AS nd WHERE u.id = :id AND u.grade = :grade AND (n.estado = 'Aprovado' OR n.estado = 'Dispensado')");
            $query->setParameter('grade', $grade);
            $query->setParameter('id', $userId);
            $usuario = $query->getResult();
        } catch (\Exception $e) {
            $usuario = null;
        }
        return $usuario;
    }

    /**
     * @param $grade
     * @param $periodo
     * @param $curso
     * @return array
     */
    public function getDisciplinasByGradePeriodo($grade, $periodo, $curso)
    {
        $gradeId = $this->getGradeId($grade, $curso);

        if(is_null($gradeId)) {
            return null;
        }

        try {
            $query = $this->em->createQuery("SELECT d FROM App\Model\Disciplina AS d LEFT JOIN d.disciplinas_grade AS dg WHERE dg.grade = :grade AND dg.periodo = :periodo");
            $query->setParameters(['grade' => $gradeId, 'periodo' => $periodo]);
            $disciplinas = $query->getResult();
        } catch (\Exception $e) {
            $disciplinas = null;
        }

        return $disciplinas;
    }

    public function getQuantidadeDisciplinasByGrade($grade, $curso)
    {
        $gradeId = $this->getGradeId($grade, $curso);

        try {
            $query = $this->em->createQuery("SELECT d FROM App\Model\Disciplina AS d LEFT JOIN d.disciplinas_grade AS dg WHERE dg.grade = :grade");
            $query->setParameters(['grade' => $gradeId]);
            $disciplinas = $query->getResult();
        } catch (\Exception $e) {
            $disciplinas = null;
        }

        return sizeof($disciplinas);
    }

    public function getGradeId($gradeCodigo, $curso)
    {
        $gradeCodigo = intval($gradeCodigo);

        try {
            $query = $this->em->createQuery("SELECT g FROM App\Model\Grade as g WHERE g.codigo = :grade AND g.curso = :curso");
            $query->setParameter('grade', $gradeCodigo);
            $query->setParameter('curso', $curso);
            $grade = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $grade = null;
        }

        if(is_null($grade)) {
            return null;
        }

        $gradeId = $grade->getId();

        return $gradeId;
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

    public function getByMatriculaNomeCursoARRAY($pesquisa, $curso = null){
        $queryCurso = "";

        if ($curso) {
            $queryCurso = "AND curso = \"$curso\"";
        }

        $sql = "SELECT * FROM usuario WHERE (usuario.matricula LIKE '%$pesquisa%' OR usuario.nome LIKE '%$pesquisa%') $queryCurso";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    public function getByMatriculaNomeCursoSemAcentoARRAY($pesquisa, $curso = null)
    {
        $queryCurso = "";

        if ($curso && $curso != 'todos') {
            $queryCurso = "WHERE curso = \"$curso\"";

            if($curso == "65B") {
                $queryCurso .= ' OR curso = "65AB"';
            }

            if($curso == "65C") {
                $queryCurso .= ' OR curso = "65AC"';
            }
        }

        $sql = "SELECT * FROM usuario $queryCurso";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $usuariosFiltrados = Helper::getUsuariosSemAcento($pesquisa, $results);

        return $usuariosFiltrados;
    }

        public function getByNomeComAmizade($pesquisa, $id){
        $sql = "SELECT usuario.id, usuario.nome, IFNULL(amizade.estado, 'nao enviado') as estado FROM usuario LEFT JOIN amizade ON usuario.id = amizade.amigo_id OR usuario.id = amizade.usuario_id WHERE (usuario.nome LIKE '%$pesquisa%') AND usuario.id != '$id'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }




    public function getByNomeComAmizadeSemAcento($pesquisa, $id){
        $sql = "SELECT usuario.id, usuario.nome, IFNULL(amizade.estado, 'nao enviado') as estado FROM usuario LEFT JOIN amizade ON usuario.id = amizade.amigo_id OR usuario.id = amizade.usuario_id AND usuario.id != '$id'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $usuariosFiltrados = Helper::getUsuariosSemAcento($pesquisa, $results);

        return $usuariosFiltrados;
    }




    public function getAmigos($id){
        $sql = "SELECT usuario.* FROM usuario JOIN amizade ON usuario.id = amizade.amigo_id OR usuario.id = amizade.usuario_id WHERE (amizade.amigo_id = '$id' OR amizade.usuario_id = '$id') AND usuario.id != '$id' AND amizade.estado='aceito' ";
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

    public function getAllByCursoARRAY($curso = null)
    {
        $queryCurso = "";
        if($curso && $curso != 'todos') {
            $queryCurso = "WHERE curso = '$curso'";

            if($curso == "65B") {
                $queryCurso .= ' OR curso = "65AB"';
            }

            if($curso == "65C") {
                $queryCurso .= ' OR curso = "65AC"';
            }
        }

        $sql = "SELECT * FROM usuario $queryCurso";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getCountNaoLogaram($curso = null)
    {
        $filtrarCurso = isset($curso) ? " AND curso = \"$curso\"" : "";
        $sql = "SELECT COUNT(*) FROM usuario WHERE usuario.primeiro_login = 1 AND usuario.tipo = 0" . $filtrarCurso;
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }


    public function getCountLogaram($curso = null)
    {
        $filtrarCurso = isset($curso) ? " AND curso = \"$curso\"" : "";

        $sql = "SELECT COUNT(*) FROM usuario WHERE (usuario.primeiro_login = 0 OR primeiro_login IS NULL) AND usuario.tipo = 0" . $filtrarCurso;
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getAlunosLogaram(){
        $sql = "SELECT * FROM usuario WHERE usuario.primeiro_login = 0";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }


    public function getTop10IraTotal(){
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.situacao = :situacao AND u.tipo = :tipo ORDER BY u.ira DESC")->setMaxResults(10);
            $query->setParameter('situacao', 0);
            $query->setParameter('tipo', 0);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    public function getTop10IraPeriodo(){
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.situacao = :situacao AND u.tipo = :tipo ORDER BY u.ira_periodo_passado DESC")->setMaxResults(10);
            $query->setParameter('situacao', 0);
            $query->setParameter('tipo', 0);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }



    public function getTop10IraTotalPorCurso($curso){
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.situacao = :situacao AND u.curso = :curso AND u.tipo = :tipo ORDER BY u.ira DESC")->setMaxResults(10);
            $query->setParameter('situacao', 0);
            $query->setParameter('tipo', 0);
            $query->setParameter('curso', $curso);
            $usuarios = $query->getResult();
        } catch (\Exception $e) {
            $usuarios = null;
        }

        return $usuarios;
    }

    public function getTop10IraPeriodoPorCurso($curso){
        try {
            $query = $this->em->createQuery("SELECT u FROM App\Model\Usuario AS u WHERE u.situacao = :situacao AND u.curso = :curso AND u.tipo = :tipo ORDER BY u.ira_periodo_passado DESC")->setMaxResults(10);
            $query->setParameter('situacao', 0);
            $query->setParameter('tipo', 0);
            $query->setParameter('curso', $curso);
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

    public function setPeriodo($usuarios, $periodo){
        foreach ($usuarios as $user){
            $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$user->getId()}', {$periodo})";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        }
    }

    public function setPeriodoOneUser($userId, $periodo)
    {
        $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ($userId, $periodo)";
        $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
        $stmt_insert->execute();
    }

    public function unsetPeriodoOneUser($userId, $periodo)
    {
        $sql = "DELETE FROM medalha_usuario WHERE usuario = $userId AND medalha = $periodo";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    public function getMedalsByIdFetched($id)
    {
        $sql = "SELECT medalha, medalha.nome, imagem FROM usuario left join medalha_usuario on usuario.id = medalha_usuario.usuario left join medalha on medalha = medalha.id WHERE usuario.id = '{$id}' ORDER BY medalha.id ASC";
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

    public function getAllUsersIds()
    {
        $sql = "SELECT id FROM usuario";
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
        $sql = "INSERT INTO db_gamificacao.amizade (usuario_id, amigo_id, estado) VALUES ('$remetente', '$destinatario', 'pendente')";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

    }

    public function getConvitesPendentes($id){
        $sql = "SELECT usuario.id, usuario.nome FROM amizade JOIN usuario ON usuario_id = usuario.id WHERE amizade.estado = 'pendente' AND amigo_id = '$id'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();
        return $results;
    }

    public function aceitarConvite($remetente, $destinatario){
        $sql = "UPDATE db_gamificacao.amizade SET amizade.estado='aceito' WHERE amizade.amigo_id = '$destinatario' AND amizade.usuario_id = '$remetente'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    public function recusarConvite($remetente, $destinatario){
        $sql = "DELETE FROM db_gamificacao.amizade WHERE amizade.amigo_id = '$destinatario' AND amizade.usuario_id = '$remetente'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

    }

    public function getNumeroMateriasTurista($userId)
    {
        $sql = "SELECT COUNT(*) as num_materias FROM usuario 
        JOIN nota ON usuario.id = nota.usuario 
        JOIN disciplina ON nota.disciplina = disciplina.id 
        WHERE usuario.id = $userId AND nota.estado = \"Aprovado\" 
        AND disciplina.codigo NOT LIKE 'DCC%' AND disciplina.codigo NOT LIKE 'MAT%' AND disciplina.codigo NOT LIKE 'FIS%' AND disciplina.codigo NOT LIKE 'EST%';";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $numMaterias =  $stmt->fetchAll();

        return intval($numMaterias[0]['num_materias']);
    }

    public function getNumeroMateriasPoliglota($userId)
    {
        $sql = "SELECT COUNT(*) as num_materias FROM usuario 
        JOIN nota ON usuario.id = nota.usuario 
        JOIN disciplina ON nota.disciplina = disciplina.id 
        WHERE usuario.id = $userId AND nota.estado = \"Aprovado\" 
        AND (
        disciplina.codigo LIKE 'UNI001%' OR
        disciplina.codigo LIKE 'UNI002%' OR
        disciplina.codigo LIKE 'UNI003%' OR
        disciplina.codigo LIKE 'UNI004%' OR
        disciplina.codigo LIKE 'UNI005%' OR
        disciplina.codigo LIKE 'UNI006%' OR
        disciplina.codigo LIKE 'UNI007%' OR
        disciplina.codigo LIKE 'UNI008%' OR
        disciplina.codigo LIKE 'UNI009%' OR
        disciplina.codigo LIKE 'UNI010%' OR
        disciplina.codigo LIKE 'UNI011%' OR
        disciplina.codigo LIKE 'UNI012%' OR
        disciplina.codigo LIKE 'UNI013%' OR
        disciplina.codigo LIKE 'UNI014%' OR
        disciplina.codigo LIKE 'UNI015%' OR
        disciplina.codigo LIKE 'UNI016%')";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $numMaterias =  $stmt->fetchAll();

        return intval($numMaterias[0]['num_materias']);
    }

    public function setTurista($userId)
    {
        $numeroMaterias = $this->getNumeroMateriasTurista($userId);

        if ($numeroMaterias >= 2) {
            $sql = "INSERT INTO medalha_usuario (usuario, medalha) VALUES ('$userId', 17)";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
        }

        if ($numeroMaterias >= 3) {
            $sql = "INSERT INTO medalha_usuario (usuario, medalha) VALUES ('$userId', 18)";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
        }

        if ($numeroMaterias >= 4) {
            $sql = "INSERT INTO medalha_usuario (usuario, medalha) VALUES ('$userId', 19)";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
        }
    }

    public function setPoliglota($userId)
    {
        $numeroMaterias = $this->getNumeroMateriasPoliglota($userId);

        if($numeroMaterias > 1){
            $sql = "INSERT INTO medalha_usuario (usuario, medalha) VALUES ('$userId', 16)";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
        }
    }

    public function setEstagio($userId)
    {
        $horasEstagio = $this->getByTipoCertificado(10, $userId);

        if(isset($horasEstagio[0]['num_horas']) && $horasEstagio[0]['num_horas'] >= 60){
            $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('$userId', 10)";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        }
    }
    
    public function setEmpresaJunior($userId)
    {
        $horasEmpresaJunior = $this->getByTipoCertificado(15, $userId);

        if(isset($horasEmpresaJunior[0]['num_horas']) && $horasEmpresaJunior[0]['num_horas'] >= 60){
            $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('$userId', 15)";
            $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
            $stmt_insert->execute();
        }
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

    public function getByTipoCertificado($tipoCertificado, $userId){
        $sql = "SELECT usuario.id , SUM(certificado.num_horas) as 'num_horas' FROM usuario JOIN certificado ON certificado.usuario = usuario.id WHERE certificado.tipo = '{$tipoCertificado}' AND usuario.id = $userId AND num_horas >= 60 AND valido = 1";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results =  $stmt->fetchAll();

        return $results;
    }

    public function setByNumMedalha($result, $numMedalha, $offset1 = 0)
    {
        if (isset($result[0]['num_horas'])) {
            if ($result[0]['num_horas'] >= 60) {
                $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$result[0]['id']}', '{$numMedalha}')";
                $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                $stmt_insert->execute();
            }


            if ($result[0]['num_horas'] >= 120) {
                $numMedalha = $numMedalha + 1;
                $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$result[0]['id']}', '{$numMedalha}')";
                $stmt_insert = $this->em->getConnection()->prepare($sql_insert);
                $stmt_insert->execute();
            }

            if ($result[0]['num_horas'] >= 180) {
                $numMedalha = $numMedalha + 1;
                $numMedalha = $numMedalha + $offset1;
                $sql_insert = "INSERT INTO db_gamificacao.medalha_usuario (usuario, medalha) VALUES ('{$result[0]['id']}', '{$numMedalha}')";
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

    public function getPeriodizados($curso = null)
    {
        $queryCurso = "";
        if($curso) {
            $queryCurso = "AND usuario.curso = '$curso'";
        }

        $sql = "SELECT * FROM medalha_usuario JOIN usuario ON usuario.id = medalha_usuario.usuario WHERE medalha_usuario.medalha = 20 $queryCurso ORDER BY usuario.ira DESC";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $alunos = $stmt->fetchAll();
        return $alunos;
    }

    public function setPeriodizado($userId, $periodoCorrente)
    {
        $periodoAtual = $this->getUsersPeriodoAtual($userId, $periodoCorrente);
        $medalhaPeriodoAtual = $this->getMedalhasPeriodoCompleto($userId, $periodoAtual);


        if(sizeof($medalhaPeriodoAtual) != 0) {
            if (sizeof($medalhaPeriodoAtual) == $periodoAtual - 1) {
                $sql = "INSERT INTO medalha_usuario (usuario, medalha) VALUES ($userId, 20)";
            } else {
                $sql = "DELETE FROM medalha_usuario WHERE usuario = $userId AND medalha = 20";
            }

            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
        }
    }

    public function getUsersPeriodoAtual($userId, $periodoCorrente)
    {
        $matricula = $this->getMatricula($userId);
        $anoMatricula = substr($matricula, 0, 4);
        $anoMatricula = intval($anoMatricula);

        $dataPeriodoCorrente = explode('-', $periodoCorrente);
        $anoPeriodoCorrente = intval($dataPeriodoCorrente[0]);
        $mesPeriodoCorrente = intval($dataPeriodoCorrente[1]);


        $periodo = ($anoPeriodoCorrente - $anoMatricula) * 2;

        if($mesPeriodoCorrente > 7) {
            $periodo += 1;
        }


        return $periodo;
    }

    public function getMatricula($userId)
    {
        $sql = "SELECT matricula FROM usuario WHERE id = $userId";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $resultado =  $stmt->fetchAll();

        return $resultado[0]['matricula'];
    }

    public function getMedalhasPeriodoCompleto($userId, $periodoAtual)
    {
        $sql = "SELECT * FROM medalha_usuario WHERE usuario = $userId AND medalha <= $periodoAtual";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getUsersPeriodo($periodo){
        $sql = "Select distinct u.id, u.nome from db_gamificacao.usuario  as u inner join db_gamificacao.nota on u.id = nota.usuario where nota.periodo = '$periodo'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getByIdFetched2($id)
    {
        $sql = "SELECT * FROM usuario LEFT JOIN usuario.certificados LEFT JOIN usuario.notas LEFT JOIN notas.disciplina WHERE usuario.id = '$id' ORDER BY notas.periodo ASC, certificados.valido ASC";
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
    

    public function setPeriodoCorrente()
    {
        try {
            $horaAtual = new \DateTime();
        } catch (\Exception $e) {
            die(var_dump($e));
        }
        $horaAtual = $horaAtual->format('Y-m-d');
        $sql = "INSERT INTO periodo_corrente (ultima_carga) VALUES ('{$horaAtual}')";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    public function getPeriodoCorrente()
    {
        $sql = "SELECT * FROM periodo_corrente ORDER BY ultima_carga DESC LIMIT 1";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $periodoCorrente = $stmt->fetchAll();

        return $periodoCorrente[0]['ultima_carga'];
    }

    public function getPosicaoAluno($id)
    {
        $sql = "SELECT id, ira FROM usuario ORDER BY ira DESC";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

        $alunos = $stmt->fetchAll();
        $posicao = 1;

        foreach ($alunos as $aluno) {
            if($aluno['id'] == $id) {
                break;
            }
            $posicao++;
        }

        $totalAlunos = $this->getQuantidadeAlunos();

        $percentil = ($posicao * 100)/$totalAlunos;

        return number_format(100 - $percentil, 0);
    }


    public function getQuantidadeAlunos()
    {
        $sql = "SELECT COUNT(id) as qtd FROM usuario";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

        $quantidade = $stmt->fetchAll()[0]['qtd'] - 2;

        return $quantidade;
    }

    public function setTodasMedalhasPeriodo($userId)
    {
        $SEASON_FINALE = 21;

        for ($periodo = 1; $periodo <= 9; $periodo++) {
            if(!$this->temMedalhaPeriodo($userId, $periodo)) {
                $sql = "INSERT INTO medalha_usuario (usuario, medalha) VALUES ($userId, $periodo)";
                $stmt = $this->em->getConnection()->prepare($sql);
                $stmt->execute();
            }
        }

        if(!$this->temMedalhaPeriodo($userId, $SEASON_FINALE)) {
            $sql = "INSERT INTO medalha_usuario (usuario, medalha) VALUES ($userId, $SEASON_FINALE)";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
        }
    }

    public function setSituacaoFormado($userId)
    {
        $sql = "UPDATE usuario SET situacao = 1 WHERE id = $userId";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    public function unsetSituacaoFormado($userId)
    {
        $sql = "UPDATE usuario SET situacao = 0 WHERE id = $userId";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    public function temMedalhaPeriodo($userId, $periodo)
    {
        $sql = "SELECT * FROM medalha_usuario WHERE medalha_usuario.usuario = $userId AND medalha_usuario.medalha = $periodo";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return sizeof($result) > 0;
    }

    public function deleteAbsentUsers($curso)
    {
        $sql = "DELETE FROM usuario WHERE curso = '$curso' AND situacao != 0 AND tipo = 0";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }

    public function getUsuariosComMesmoNome()
    {
        $query = "SELECT a.* FROM usuario AS a JOIN (SELECT nome, COUNT(*) FROM usuario GROUP BY nome HAVING count(*) > 1 ) b ON a.nome = b.nome";

        $stmt = $this->em->getConnection()->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function deleteById($id)
    {
        $query = "DELETE FROM usuario WHERE id = $id";

        $stmt = $this->em->getConnection()->prepare($query);

        $stmt->execute();
    }


}
