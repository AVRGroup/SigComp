<?php

namespace App\Controller;

require __DIR__ . '/../../../vendor/autoload.php';

use App\Library\CalculateAttributes;
use App\Library\Helper;
use App\Model\Disciplina;
use App\Model\Grade;
use App\Model\GradeDisciplina;
use App\Model\Nota;
use App\Model\Usuario;
use Dompdf\Options;
use PHPMailer\PHPMailer\Exception;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Dompdf\Dompdf;
use App\Library\MailSender;
use Doctrine\ORM\Query\AST\Functions\LengthFunction;
use phpoffice\phpword\src\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\TablePosition;

class AdminController
{

    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function dataLoadAction(Request $request, Response $response, $args)
    {
        $curso = null;
        $arrayCurso = array();
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        if($request->getParam('curso') == "todos"){
            $arrayCurso[] = "35A";
            $arrayCurso[] = "65C";
            $arrayCurso[] = "76A";
            $arrayCurso[] = "65B";
        } 
        else if($request->getParam('curso') !== null && 
        $request->getParam('curso') !== "none" && 
        $request->getParam('curso') !== ""){
            $curso = $request->getParam('curso');
        }
        else {
            $curso = $usuario->getCurso(); 
        }
        
        $consumo = 0;
        $affectedData = ['disciplinasAdded' => 0, 'usuariosAdded' => 0, 'usuariosUpdated' => 0];

        $data = null;
        $matriculas = array();
        $matriculasImportadas = array();
        if(sizeof($arrayCurso) > 0){
            $data = array();
            foreach($arrayCurso as $curso){
                $dataAux = $this->importarAlunos($curso);
                $data = array_merge($data, $dataAux);
                $matriculasAux = $this->container->usuarioDAO->getAllMatriculasByCurso($curso);
                $matriculas = array_merge($matriculas, $matriculasAux);
            }
        }
        else{
            $data = $this->importarAlunos($curso);
            $matriculas = $this->container->usuarioDAO->getAllMatriculasByCurso($curso);
        }

        $disciplinas = array();

        if ($data !== null) {
            $consumo++;
            try {
                set_time_limit(60 * 60); //Should not Exit
                 
                $disciplinas = array();
                // Inserindo/atualizando usuários e adicionando suas notas
                foreach ($data as $user) {
                    if(!in_array($user['Matrícula'], $matriculasImportadas)){
                        $matriculasImportadas[] = $user['Matrícula'];    
                    }
                    $curso = $user['Curso'];

                    //Atualiza/adiciona usuário
                    $usuario_aux = $this->container->usuarioDAO->getUserByMatricula($user['Matrícula']);
                    if ($usuario_aux !== null) {
                        $usuario = $usuario_aux;
                        //Se não está no map, insere neste e atualiza
                        /*foreach ($usuario->getNotas() as $userNota) {
                            $usuario->removeNota($userNota);
                            $this->container->notaDAO->remove($userNota);
                        }*/
                        $usuarioAffected = false;
                        if($usuario->getNome() != $user['Nome Aluno']){
                            $usuario->setNome($user['Nome Aluno']);
                            $usuarioAffected = true;
                        }
                        if($usuario->getGrade() != $user['Grade']){
                            $usuario->setGrade($user['Grade']);
                            $usuarioAffected = true;
                        }

                        if($usuarioAffected){
                            $this->container->usuarioDAO->save($usuario); 
                        }
                        $affectedData['usuariosUpdated']++;
                        
                    } else {
                        $usuario = new Usuario();
                        $usuario->setNome($user['Nome Aluno']);
                        $usuario->setGrade($user['Grade']);
                        $usuario->setCurso($user['Curso']);
                        $usuario->setMatricula($user['Matrícula']);

                        $this->container->usuarioDAO->persist($usuario);
                        $affectedData['usuariosAdded']++;
                    }

                    //Atualiza histórico e adiciona novas disciplinas
                    $historicoAluno = $user['Histórico'];
                    if($historicoAluno !== null && (sizeof($historicoAluno) > 0)){
                        foreach ($historicoAluno as $historico) {
                            
                            //Adiciona disciplinas
                            $disciplinaAffected = false;
                            if(!array_key_exists($historico['Código Disciplina'], $disciplinas)){
                                $disciplina_aux = $this->container->disciplinaDAO->getByCodigo($historico['Código Disciplina']);
                                if ($disciplina_aux !== null) {
                                    if($disciplina_aux->getNome() != $historico['Nome Disciplina']){
                                        $disciplina_aux->setNome($historico['Nome Disciplina']);
                                        $this->container->disciplinaDAO->save($disciplina_aux);
                                        $disciplinaAffected = true;
                                    }
                                }
                                else{
                                    $disciplina = new Disciplina();
                                    $disciplina->setCodigo($historico['Código Disciplina']);
                                    $disciplina->setCarga($historico['Carga Horária']);
                                    $disciplina->setNome($historico['Nome Disciplina']);
                                    $this->container->disciplinaDAO->persist($disciplina);
    
                                    $affectedData['disciplinasAdded']++;
                                    $disciplinaAffected = true;
                                }

                                $disciplinas[$historico['Código Disciplina']] = true;
                            }
                            if($disciplinaAffected){
                                $this->container->disciplinaDAO->flush(); //Commit the transaction
                            }

                            //Atualiza histórico
                            //----------------------------------------------------------------
                            if($historico['Situação'] !== null && $historico['Semestre Cursado'] !== null && $historico['Nota'] !== null){
                                $create = true;
                                $notas = $usuario->getNotas();
                                if($notas !== null && sizeof($notas)){
                                    foreach ($notas as $nota) {
                                        if(($nota->getPeriodo() == $historico['Semestre Cursado']) && ($nota->getDisciplina()->getCodigo() == $historico['Código Disciplina'])){
                                            $create = false;
                                            $notaAffected = false;
                                            if($nota->getEstado() !== $historico['Situação']){
                                                $nota->setEstado($historico['Situação']);
                                                $notaAffected = true;
                                            }
                                            if($nota->getValor() != $historico['Nota']){
                                                $nota->setValor($historico['Nota']);
                                                $notaAffected = true;
                                            }

                                            if($notaAffected){
                                                $this->container->notaDAO->save($nota);
                                            }
                                        }
                                    }
                                }
                                if($create){
                                    $nota = new Nota();
                                    $nota->setEstado($historico['Situação']);
                                    $nota->setValor($historico['Nota']);
                                    $nota->setPeriodo($historico['Semestre Cursado']);
                                    $nota->setDisciplina($this->container->disciplinaDAO->getByCodigo($historico['Código Disciplina']));
                                    $usuario->addNota($nota);
                                    $this->container->notaDAO->persist($nota); 
                                }
                            }
                            //----------------------------------------------------------------

                            /*if($historico['Situação'] !== null && $historico['Semestre Cursado'] !== null && $historico['Nota'] !== null){
                                $nota = new Nota();
                                $nota->setEstado($historico['Situação']);
                                $nota->setValor($historico['Nota']);
                                $nota->setPeriodo($historico['Semestre Cursado']);
                                $nota->setDisciplina($this->container->disciplinaDAO->getByCodigo($historico['Código Disciplina']));
                                $usuario->addNota($nota);
                                $this->container->notaDAO->persist($nota);
                            }*/

                        }
                    }

                    $usuarioAffected = false;
                    //Atualiza IRA do aluno
                    $IRA = $user['IRA Acumulado'];
                    if($usuario->getIra() != $user['IRA Acumulado']){
                        $usuario->setIra($user['IRA Acumulado']);
                        $usuarioAffected = true;
                    }

                    //IRA período passado
                    $IRAs = $user['IRAs Semestre'];
                    if($IRAs !== null && (sizeof($IRAs) > 0)){
                        foreach ($IRAs as $iraPassado){
                            if($this->getPeriodoPassado() == $iraPassado['Semestre'] &&
                               $usuario->getIraPeriodoPassado() != $iraPassado['IRA']){
                                
                                $usuario->setIraPeriodoPassado($iraPassado['IRA']);
                                $usuarioAffected = true;
                            }
                        }
                    }

                    if($usuarioAffected){
                        $this->container->usuarioDAO->save($usuario); 
                    } 
                }

                $this->container->usuarioDAO->flush(); //Commit the transaction
                $this->container->notaDAO->flush();

                //Exclui usuários com matrícula inativa
                if($matriculas != null && sizeof($matriculas) > 0){
                    $invalidos = array();
                    foreach($matriculas as $matricula){
                        $achou = false;
                        foreach($data as $user){
                            if($matricula == $user['Matrícula']){
                                $achou = true;
                                break;
                            }
                        }
                        if(!$achou){
                            $invalidos[] = $matricula;
                        }
                    }

                    if(sizeof($invalidos) > 0){
                        $this->container->usuarioDAO->deleteByMatriculas($invalidos);
                        $this->container->usuarioDAO->flush();
                    }
                }

            } catch (\Exception $e) {
                $this->container->view['error'] = $e->getMessage();
            }
        }

        if($consumo !== 0){
            $this->container->view['affectedData'] = $affectedData;
            $this->container->view['success'] = true;

            /*Se fez a carga para todos os cursos, já excluiu usuários com matrícula inativa,
            senão, manter usuário com matrícula válida, ou seja, que veio na carga do curso em questão*/
            if(sizeof($arrayCurso) > 0){
                $this->deletaUsuariosDuplicados(null, $matriculasImportadas);
            } else {
                $this->deletaUsuariosDuplicados($curso, $matriculasImportadas);
            }
            

            //$this->calculaIra();
            //$this->calculaIraPeriodoPassado();
            
            if(sizeof($arrayCurso) > 0){
                foreach($arrayCurso as $curso){
                    $this->abreviaTodosNomes(false, $curso);
                    $this->abreviaTodosNomes(true, $curso);
                }
            } else{
                $this->abreviaTodosNomes(false, $curso);
                $this->abreviaTodosNomes(true, $curso);
            }

            $this->container->usuarioDAO->setPeriodoCorrente();
            $periodo = $this->getPeriodoAtual();

            $this->container->usuarioDAO->setActiveUsers($this->container->usuarioDAO->getUsersPeriodo($periodo));
            if(sizeof($arrayCurso) > 0){
                foreach($arrayCurso as $curso){
                    $this->container->usuarioDAO->deleteAbsentUsers($curso);
                }
            } else{
                $this->container->usuarioDAO->deleteAbsentUsers($curso);
            }

        }
        else{
            $this->container->view['error'] = "Não foi possível realizar a carga";
        }

        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $this->container->view['usuario'] = $usuario;
        return $this->container->view->render($response, 'adminDataLoad.tpl');
    }

    public function importarAlunos($curso){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "200.131.219.214:8080/GestaoCurso/services/historico/get/$curso",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "token: d6189421e0278587f113ca4b9e258c4a9f8de468"
            ),
        ));

        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $result;
    }

    public function deletaUsuariosDuplicados($curso, $matriculasImportadas)
    {
        $usuarioDuplicados = $this->container->usuarioDAO->getUsuariosComMesmoNome();
        $idsParaDeletar = [];

        if ($usuarioDuplicados === null || !is_array($usuarioDuplicados)) {
            return;
        }

        for($i = 0; $i < sizeof($usuarioDuplicados); $i++) {
            $usuario = $usuarioDuplicados[$i];
            $final = substr($usuario['matricula'], -2);

            if ($final === "AC") {
                $idsParaDeletar[] = $usuario['id'];
            } 
            
            else {
                for($j = $i + 1; $j < sizeof($usuarioDuplicados); $j++){
                    $usuarioAux = $usuarioDuplicados[$j];
                    if($usuario['nome'] == $usuarioAux['nome'] && 
                    $usuario['matricula'] != $usuarioAux['matricula']){
                        $anoMatriculaUsuario = intval(substr($usuario['matricula'],0,4));
                        $anoMatriculaUsuarioAux = intval(substr($usuarioAux['matricula'],0,4));
                        
                        if($anoMatriculaUsuario < $anoMatriculaUsuarioAux){
                            $idsParaDeletar[] = $usuario['id'];
                        } else if($anoMatriculaUsuario > $anoMatriculaUsuarioAux){
                            $idsParaDeletar[] = $usuarioAux['id'];
                        } else if(!in_array($usuario['matricula'], $matriculasImportadas) && 
                            in_array($usuarioAux['matricula'], $matriculasImportadas)){
                                $idsParaDeletar[] = $usuario['id'];
                        } else if(in_array($usuario['matricula'], $matriculasImportadas) && 
                            !in_array($usuarioAux['matricula'], $matriculasImportadas)){
                                $idsParaDeletar[] = $usuarioAux['id'];
                        } else if($curso != null){
                            if($usuario['curso'] == $curso){
                                $idsParaDeletar[] = $usuarioAux['id'];
                            } else if($usuarioAux['curso'] == $curso){
                                $idsParaDeletar[] = $usuario['id'];
                            } else {
                                echo "<script>alert('O ano das matrículas do usuário ". $usuario['nome'] ." é o mesmo (1 - ". $usuario['matricula'] .", 2 - ". $usuarioAux['matricula'] ."). Favor informar ao suporte qual é a matrícula ativa')</script>";
                            }
                        } else{
                            echo "<script>alert('O ano das matrículas do usuário ". $usuario['nome'] ." é o mesmo (1 - ". $usuario['matricula'] .", 2 - ". $usuarioAux['matricula'] ."). Favor informar ao suporte qual é a matrícula ativa')</script>";
                        }
                    }
                }
            }
        }

        foreach($idsParaDeletar as $id) {
            $this->container->usuarioDAO->deleteById($id);
        }

        return;
    }

    public function calculaIra()
    {
        $usuarios = $this->container->usuarioDAO->getAllFetched();

        /** @var Usuario $usuario */
        foreach ($usuarios as $usuario) {
            $somatorioNotasVezesCargas = 0;
            $somatorioCargas = 0;

            /** @var Nota $nota */
            foreach ($usuario->getNotas() as $nota) {
                if ($nota->getEstado() == "Matriculado" || $nota->getEstado() == "Trancado" || $nota->getEstado() == "Dispensado" || $nota->getEstado() == "Cancelado") {
                    continue;
                }

                $departamento = substr($nota->getDisciplina()->getCodigo(), 0, 3);

                if ($departamento != 'DCC' && $departamento != 'EST' && $departamento != 'MAT' && $departamento != 'FIS') {
                    continue;
                }

                $somatorioNotasVezesCargas += $this->calculaNotaVezesCarga($nota);
                $somatorioCargas += $nota->getDisciplina()->getCarga();
            }

            if ($somatorioCargas != 0) {
                $ira = $somatorioNotasVezesCargas / $somatorioCargas;
            } else {
                $ira = 0;
            }
            
            $usuario->setIra($ira);

            try {
                $this->container->usuarioDAO->save($usuario);
            } catch (\Exception $e) {
                echo $e;
            }
        }
    }

    public function calculaIraPeriodoPassado()
    {
        $usuarios = $this->container->usuarioDAO->getAllFetched();

        /** @var Usuario $usuario */
        foreach ($usuarios as $usuario) {
            if($usuario->getSituacao() == 1) {
                continue;
            }

            $somatorioNotasVezesCargas = 0;
            $somatorioCargas = 0;

            /** @var Nota $nota */
            foreach ($usuario->getNotas() as $nota) {

                if ($nota->getPeriodo() != $this->getPeriodoPassado()) {
                    continue;
                }

                if ($nota->getEstado() == "Matriculado" || $nota->getEstado() == "Trancado" || $nota->getEstado() == "Dispensado" || $nota->getEstado() == "Cancelado") {
                    continue;
                }

                $departamento = substr($nota->getDisciplina()->getCodigo(), 0, 3);

                if ($departamento != 'DCC' && $departamento != 'EST' && $departamento != 'MAT' && $departamento != 'FIS') {
                    continue;
                }

                $somatorioNotasVezesCargas += $this->calculaNotaVezesCarga($nota);
                $somatorioCargas += $nota->getDisciplina()->getCarga();
            }

            if ($somatorioCargas != 0) {
                $ira = $somatorioNotasVezesCargas / $somatorioCargas;
            } else {
                $ira = 0;
            }

            if ($somatorioCargas >= 60 * 4) {
                $usuario->setIraPeriodoPassado($ira);
            } else {
                $usuario->setIraPeriodoPassado(0);
            }

            try {
                $this->container->usuarioDAO->save($usuario);
            } catch (\Exception $e) {
                echo $e;
            }
        }
        $this->container->usuarioDAO->flush(); //Commit the transaction
    }

    public function calculaNotaVezesCarga($nota){
        /** @var Nota $nota */

        if($nota->getValor() === 'A')
            return 100 * (float)$nota->getDisciplina()->getCarga();

        if($nota->getValor() === 'B')
            return 90 * (float)$nota->getDisciplina()->getCarga();

        if($nota->getValor() === 'C')
            return 80 * (float)$nota->getDisciplina()->getCarga();

        return (float)$nota->getValor() * (float)$nota->getDisciplina()->getCarga();
    }


    public function abreviaTodosNomes($isPeriodoPassado, $curso){
        if($isPeriodoPassado)
            $usuarios = $this->container->usuarioDAO->getAllFetched10PrimeirosPorIraPeriodoPassado($curso);
        else
            $usuarios = $this->container->usuarioDAO->getAllFetched10PrimeirosPorIra($curso);


        /** @var Usuario $usuario */
        foreach ($usuarios as $usuario) {
            $nomeAbreviado =  $this->abreviaNome($usuario->getNome(), 123);
            $usuario->setNomeAbreviado($nomeAbreviado);

            try {
                $this->container->usuarioDAO->flush();
            }
            catch (\Exception $e) {
                echo $e;
            }
        }
    }

    public function abreviaNome($nome, $tamanhoMax){
        $deveAbreviar = true;

        //Se o nome cabe na linha sem abreviar, não devemos abreviar;
        if(strlen($nome) <= 30)
            return $nome;

        $offset = 1;

        while($deveAbreviar){
            $indicePrimeiraLetra = $this->indicePrimeiraLetraSobrenome($nome, $offset);
            $indiceUltimaLetra =  $this->indiceUltimaLetraSobrenome($nome, $offset);
            $tamanhoNome = $indiceUltimaLetra - $indicePrimeiraLetra;

            $nome[$indicePrimeiraLetra + 1] = '.';
            $nome = substr_replace($nome, '', $indicePrimeiraLetra + 2, $tamanhoNome - 1);

            if(strlen($nome) <= 30)
                $deveAbreviar = false;
            else
                $offset++;
        }

        return $nome;
    }

    //offset para indicar qual sobrenome deve ser abreviado. Por exemplo, contando de traz pra frente,
    // um nome com 2 sobrenomes e offset = 1 abreviria o segundo, pois 3 - 1 = 2. (3 seria o numero de 'nomes' total)
    public function indicePrimeiraLetraSobrenome($nome, $offset){
        $numEspacosEmBrancoTotal = substr_count($nome, ' ');
        $numEspacosEmBrancoContados = 0;

        for($i=0; $i<strlen($nome); $i++) {
            if($nome[$i] === ' ')
                $numEspacosEmBrancoContados++;

            if($numEspacosEmBrancoContados == $numEspacosEmBrancoTotal - $offset )
                return $i + 1;
        }

        return -1;
    }

    public function indiceUltimaLetraSobrenome($nome, $offset){
        $numEspacosEmBrancoTotal = substr_count($nome, ' ');
        $numEspacosEmBrancoContados = 0;

        for($i=0; $i<strlen($nome); $i++) {
            if($nome[$i] === ' ')
                $numEspacosEmBrancoContados++;

            if($numEspacosEmBrancoContados == $numEspacosEmBrancoTotal - $offset + 1)
                return $i - 1;
        }

        return -1;
    }

    public function gradeLoadAction(Request $request, Response $response, $args)
    {
        if ($request->isPost() && isset($request->getUploadedFiles()['data'])) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $request->getUploadedFiles()['data'];

            if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                $this->container->view['error'] = 'Erro no upload do arquivo, tente novamente!';
            } else {
                $extension = mb_strtolower(pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION));
                if (!in_array($extension, $this->container->settings['upload']['allowedDataLoadExtensions'])) {
                    $this->container->view['error'] = 'Formato ou Tamanho do certificado inválido!';
                } else {
                    try {
                        $nomeArquivo = $uploadedFile->getClientFilename();

                        preg_match("/.+(?=-)/" , $nomeArquivo, $cursoGrade);
                        preg_match("/(?<=\-).+(?=\.)/", $nomeArquivo, $codigoGrade);

                        $data = Helper::processGradeCSV($uploadedFile->file);
                        $affectedData = ['disciplinasAdded' => 0];
                        $grade = new Grade();
                        $grade->setCodigo($codigoGrade[0]);
                        $grade->setCurso($cursoGrade[0]);
                        $this->container->gradeDAO->persist($grade);
                        $this->container->gradeDAO->flush();

                        $disciplinas = Helper::convertToIdArray($this->container->disciplinaDAO->getAll());
                        $this->container->view['vetor'] = $data;
                        $this->container->view['disciplinas'] = $disciplinas;

                        foreach ($data['disciplinas'] as $disc) {

                            if($disc['codigo'] == "Disciplinas Eletivas") {
                                break;
                            }

                            if(!isset($disc['codigo']) || !isset($disc['nome'])) {
                                continue;
                            }

                            $disciplinasGrade = new GradeDisciplina();
                            if (isset($disciplinas[$disc['codigo']])) {
                                $bool = 1;
                                $this->container->view['boolean'] = $bool;
                                $disciplinasGrade->setGrade($grade);
                                $disciplinasGrade->setDisciplina($disciplinas[$disc['codigo']]);
                                $disciplinasGrade->setPeriodo($disc['periodo']);
                                $disciplinasGrade->setTipo(0);
                                $this->container->gradeDisciplinaDAO->persist($disciplinasGrade);
                            }else{
                                $disciplina = new Disciplina();
                                $disciplina->setCodigo($disc['codigo']);
                                $disciplina->setCarga($disc['carga']);
                                $disciplina->setNome($disc['nome']);
                                $this->container->disciplinaDAO->persist($disciplina);
                                $disciplinas[$disciplina->getCodigo()] = $disciplina; //Added to existing Disciplinas
                                $disciplinasGrade->setGrade($grade);
                                $disciplinasGrade->setDisciplina($disciplina);
                                $disciplinasGrade->setPeriodo($disc['codigo']);
                                $disciplinasGrade->setTipo(0);
                                $this->container->gradeDisciplinaDAO->persist($disciplinasGrade);
                            }
                            $affectedData['disciplinasAdded']++;
                        }
                        $this->container->view['affectedData'] = $affectedData;
                        $this->container->view['success'] = true;
                        $this->container->disciplinaDAO->flush(); //Commit the transaction
                        $this->container->gradeDisciplinaDAO->flush();
                    } catch (\Exception $e) {
                        $this->container->view['error'] = $e->getMessage();
                    }
                }
            }
        }

        $usuario = $this->container->usuarioDAO->getUsuarioLogado();

        if($usuario->isAdmin()) {
            $grades = $this->container->gradeDAO->getAll();
        } else {
            $grades = $this->container->gradeDAO->getAllByCurso($usuario->getCurso());
        }

        $this->container->view['grades'] = $grades;

        return $this->container->view->render($response, 'adminGradeLoad.tpl');
    }

    public function adicionaNomeAsDisciplinas($data)
    {
        foreach ($data['disciplinas'] as $disc) {
            if(isset($disc['nome']) && $disc['nome'] != false){

                $disciplina = $this->container->disciplinaDAO->getByCodigo($disc['codigo']);

                if(isset($disciplina)) {
                    $disciplina->setNome($disc['nome']);
                    $this->container->disciplinaDAO->persist($disciplina);
                    $this->container->disciplinaDAO->flush(); //Commit the transaction
                }
            }
        }

    }

    public function adminData(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'data.tpl');
    }

    public function adminDashboardAction(Request $request, Response $response, $args){
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();
        $parametro = $request->getParam('curso');

        $curso = null;
        if($usuario->isCoordenador()) {
            $curso = $usuario->getCurso();
        } elseif(isset($parametro)) {
            $curso = $parametro;
        }

        $this->container->view['countNaoLogaram'] = $this->container->usuarioDAO->getCountNaoLogaram($curso)[0]["COUNT(*)"];
        $this->container->view['countLogaram'] = $this->container->usuarioDAO->getCountLogaram($curso)[0]["COUNT(*)"];

        if(isset($curso)) {
            $this->container->view['top10Ira'] = $this->container->usuarioDAO->getTop10IraTotalPorCurso($curso);
            $this->container->view['top10IraPeriodoPassado'] = $this->container->usuarioDAO->getTop10IraPeriodoPorCurso($curso);
        }
        else {
            $this->container->view['top10Ira'] = $this->container->usuarioDAO->getTop10IraTotal();
            $this->container->view['top10IraPeriodoPassado'] = $this->container->usuarioDAO->getTop10IraPeriodo();
        }

        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['periodoPassado'] = $this->getPeriodoPassado();

        return $this->container->view->render($response, 'adminDashboard.tpl');
    }

    public function exportPDFAction(Request $request, Response $response, $args){
        $aluno = $this->container->usuarioDAO->getById($args['id']);
        $certificados = $this->container->certificadoDAO->getValidatedByUsuario($aluno);

        $caminhoImagem = realpath(__DIR__ . '/../../../public/img/logo_ufjf.png');
        $imagemBase64 = require "logoBase64.php";

        $horas = $this->horasTotais($certificados);

        $language = new \PhpOffice\PhpWord\Style\Language(\PhpOffice\PhpWord\Style\Language::PT_BR);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->getSettings()->setThemeFontLang($language);

        $fontStyle = array(
            'name' => 'Arial',
            'size' => 13,
            'valign' =>'both'
        );
        $fontStyleTitle = array(
            'name' => 'Arial',
            'size' => 12,
            'bold' => true
        );
        $fontStyleCommon = array(
            'name' => 'Arial',
            'size' => 12,
            'align' => 'center'
        );
        $fontStyleCommon2 = array(
            'name' => 'Arial',
            'size' => 12,
            'align' => 'both'
        );
        $styleTable = array(
            'borderSize' => 8,
            'borderColor' => '000000',
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        );
        $styleCell = array(
            'vMerge' => 'restart', 
            'valign' => 'center',
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        );

        $section = $phpWord->createSection();
        $section->addText('Nome: '.$aluno->getNome(). '', $fontStyle);
        $section->addText('Matrícula: ' .$aluno->getMatricula(). '', $fontStyle);
        $section->addText('Horas computadas: ' . $horas . '', $fontStyle);
        
        $section->addText('Relação das atividades realizadas:', $fontStyleTitle);
        $phpWord->addTableStyle('Arial', $styleTable);
        $table = $section->addTable('Arial');

        $row = $table->addRow();
        $row->addCell(1200, $styleCell)->addText(' Períodos', $fontStyleCommon);
        $row->addCell(6800)->addText(' Atividade', $fontStyleCommon);
        $row->addCell(1000, $styleCell)->addText(' Horas', $fontStyleCommon);

        $periodoAnteriorInicio = '1990.1';
        foreach ($certificados as $certificado)
        {
            if($certificado->getValido())
            {
                $periodoInicio = $this->getPeriodoInicioLegivel($certificado);
                $periodoFim = $this->getPeriodoFimLegivel($certificado);

                
                if($periodoAnteriorInicio != $periodoInicio)
                {
                    $table->addRow();
                    if($periodoFim > $periodoInicio)
                    {
                        $row = $table->addCell(1200, $styleCell);
                        $row->addText('   ' .$periodoInicio. ' a ' .$periodoFim .'', $fontStyleCommon);
                    }
                    else
                    {
                        $row = $table->addCell(1200, $styleCell);
                        $row->addText('   ' .$periodoInicio. '', $fontStyleCommon);
                    }
                    $row2 = $table->addCell(6800, $styleCell);
                    $row2->addText(''.$certificado->getNomeTipo().   ': ' . $certificado->getNomeImpresso() .';', $fontStyleCommon);
                    $row3 = $table->addCell(1000, $styleCell);
                    $row3->addText('     '.$certificado->getNumHoras().'', $fontStyleCommon);
                }
                else 
                {
                    $row2->addText(''.$certificado->getNomeTipo().   ': ' . $certificado->getNomeImpresso() .';', $fontStyleCommon);
                    $row3->addText('     '.$certificado->getNumHoras().'', $fontStyleCommon);
                }
                $periodoAnteriorInicio = $periodoInicio;   
            }
                     
        }

        $file = 'pre-parecer.docx';
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save("php://output");
    }

    public function horasTotais($certificados){
        $horas = 0;

        foreach ($certificados as $certificado){
            $horas += $certificado->getNumHoras();
        }

        return $horas;
    }

    public function getPeriodoInicioLegivel($certificado) : string {
        $anoInicio  = $certificado->getDataInicio()->format('Y');
        $mesInicio  = $certificado->getDataInicio()->format('m');

        $periodo = $anoInicio . '.' . $this->formataSemestre($mesInicio);

        if($certificado->getDataInicio1() != null) {

            $anoInicio = $certificado->getDataInicio1()->format('Y');
            $mesInicio = $certificado->getDataInicio1()->format('m');

            $periodo .= '<br>' . $anoInicio . '.' . $this->formataSemestre($mesInicio);

        }

        if($certificado->getDataInicio2() != null) {
            $anoInicio = $certificado->getDataInicio2()->format('Y');
            $mesInicio = $certificado->getDataInicio2()->format('m');


            $periodo .= '<br>' . $anoInicio . '.' . $this->formataSemestre($mesInicio);
        }

        return $periodo;
    }

    public function getPeriodoFimLegivel($certificado) : string {
        $anoInicio  = $certificado->getDataFim()->format('Y');
        $mesInicio  = $certificado->getDataFim()->format('m');

        $periodo = $anoInicio . '.' . $this->formataSemestre($mesInicio);

        if($certificado->getDataFim1() != null) {

            $anoInicio = $certificado->getDataFim1()->format('Y');
            $mesInicio = $certificado->getDataFim1()->format('m');

            $periodo .= '<br>' . $anoInicio . '.' . $this->formataSemestre($mesInicio);

        }

        if($certificado->getDataFim2() != null) {
            $anoInicio = $certificado->getDataFim2()->format('Y');
            $mesInicio = $certificado->getDataFim2()->format('m');


            $periodo .= '<br>' . $anoInicio . '.' . $this->formataSemestre($mesInicio);
        }

        return $periodo;
    }


    public function formataSemestre($mesInicio){
        return $mesInicio > 6 ? '3' : '1';
    }

    public function listAlunosLogaramAction(Request $request, Response $response, $args){
        $this->container->view['alunos'] = $this->container->usuarioDAO->getAlunosLogaram();

        return $this->container->view->render($response, 'usuariosLogaram.tpl');
    }

    public function adminUserAction(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getByIdFetched($args['id']);

        if(!$usuario) {
            return $response->withRedirect($this->container->router->pathFor('adminListUsers'));
        }


        $medalhasUsuario = $this->container->usuarioDAO->getMedalsByIdFetched($usuario->getId());

        $this->container->view['medalhas'] = $medalhasUsuario;
        $this->container->view['isAdmin'] = true;
        $this->container->view['usuario'] = $usuario;
        $this->container->view['todasMedalhas'] =  $this->container->usuarioDAO->getTodasMedalhas();

        $this->container->view['top10Ira'] = $this->container->usuarioDAO->getTop10IraTotalPorCurso($usuario->getCurso());
        $this->container->view['top10IraPeriodoPassado'] = $this->container->usuarioDAO->getTop10IraPeriodoPorCurso($usuario->getCurso());
        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
        $this->container->view['posicaoGeral'] = $this->container->usuarioDAO->getPosicaoAluno($usuario->getId());
        $this->container->view['xpTotal'] = $this->container->usuarioDAO->getQuantidadeDisciplinasByGrade($usuario->getGrade(), $usuario->getCurso()) * 100;

        $this->container->view['grupos'] = Helper::getGruposComPontuacao($this->container, $usuario);
        $this->container->view['gruposCursoInteiro'] = Helper::getGruposComPontuacao($this->container, $usuario, true);

        return $this->container->view->render($response, 'home.tpl');
    }

    public function getPeriodoPassado()
    {
        $periodoAtual = $this->getPeriodoAtual();
        $semestre = intval($periodoAtual[4]);
        $ano = substr($periodoAtual, 0, 4);

        if($semestre == 1) {
            $anoAnterior = date('Y', strtotime($ano . " -1 year"));
            $periodoAnterior = $anoAnterior . 3;
        }
        else {
            $periodoAnterior = $ano . 1;
        }

        return intval($periodoAnterior);
    }

    public function getPeriodoAtual()
    {
        $ultimaCarga = $this->container->usuarioDAO->getPeriodoCorrente();
        if(strpos($ultimaCarga, "-")){
            $ultimaCarga = explode("-", $ultimaCarga);
            $ano = $ultimaCarga[0];
            $mes = intval($ultimaCarga[1]);
            
            if($mes > 6) {
                $periodo = $ano . 3;    
            }
            else {
                $periodo = $ano . 1;
            }

            return $periodo;
        }
        return $ultimaCarga;
        
    }


    public function listPeriodizadosAction(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();

        $curso = null;
        $parametro = $request->getParam('curso');

        if ($usuario->isCoordenador()) {
            $curso = $usuario->getCurso();
        }
        elseif(isset($parametro)) {
            $curso = $parametro;
        }

        $this->container->view['users'] = $this->container->usuarioDAO->getPeriodizados($curso);

        return $this->container->view->render($response, 'periodizados.tpl');
    }

    public function setConcluido(Request $request, Response $response, $args)
    {
        $id = $request->getParsedBodyParam('id');

        $this->container->usuarioDAO->setTodasMedalhasPeriodo($id);
        $this->container->usuarioDAO->setSituacaoFormado($id);

        return  $response->withRedirect($this->container->router->pathFor('adminListUsers'));
    }

    public function unsetConcluido(Request $request, Response $response, $args)
    {
        $SEASON_FINALE = 21;
        $id = $request->getParsedBodyParam('id');

        for($periodo = 1; $periodo <= 9; $periodo++) {
            if ($this->concluiuPeriodo($id, $periodo) && !$this->container->usuarioDAO->temMedalhaPeriodo($id, $periodo) ) {
                $this->container->usuarioDAO->setPeriodoOneUser($id, $periodo);
            }
            if (!$this->concluiuPeriodo($id, $periodo) && $this->container->usuarioDAO->temMedalhaPeriodo($id, $periodo) ) {
                $this->container->usuarioDAO->unsetPeriodoOneUser($id, $periodo);
            }
        }

        if($this->container->usuarioDAO->temMedalhaPeriodo($id, $SEASON_FINALE)){
            $this->container->usuarioDAO->unsetPeriodoOneUser($id, $SEASON_FINALE);
        }

        $this->container->usuarioDAO->unsetSituacaoFormado($id);

        return  $response->withRedirect($this->container->router->pathFor('adminListUsers'));
    }

    public function concluiuPeriodo($userId, $periodo)
    {
        $user = $this->container->usuarioDAO->getById($userId);
        $user = $this->container->usuarioDAO->getSingleUsersNotasByGrade($userId, $user->getGrade())[0];
        $disciplinas = $this->container->usuarioDAO->getDisciplinasByGradePeriodo($user->getGrade(), $periodo, $user->getCurso());
        $cont = 0;

        $user_notas = $user->getNotas();

        foreach ($disciplinas as $disciplina){
            foreach ($user_notas as $un){
                if ($disciplina->getCodigo() == $un->getDisciplina()->getCodigo()) {
                    $cont++;
                }
                else if ($un->getDisciplina()->getCodigo() == $disciplina->getCodigo()."E") {
                    $cont++;
                }
            }
        }

        if(sizeof($disciplinas) > 0){
            if ($cont == sizeof($disciplinas)){
                return true;
            }
        }

        return false;
    }


    public function impersonarUsuario(Request $request, Response $response, $args)
    {
        $usuarioOriginal = $this->container->usuarioDAO->getUsuarioLogado();
        $idUsuario = $args['id'];

        $_SESSION['id'] = $idUsuario;
        $_SESSION['idOriginal'] = $usuarioOriginal->getId();
        $_SESSION['estaImpersonando'] = true;

        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function sairImpersonar(Request $request, Response $response, $args)
    {
        if(isset($_SESSION['estaImpersonando'])) {
            $_SESSION['id'] = $_SESSION['idOriginal'];

            unset($_SESSION['idOriginal']);
            unset($_SESSION['estaImpersonando']);
        }

        return $response->withRedirect($this->container->router->pathFor('adminListUsers'));

    }

    public function compareUsers(Request $request, Response $response, $args)
    {
        $users = [];

        $pesquisaCurso = $request->getQueryParam('curso');
        $pesquisaNome = $request->getQueryParam('nome');

        $usuarioLogado = $this->container->usuarioDAO->getUsuarioLogado();

        $todosUsuarios = $this->container->usuarioDAO->getAllARRAY();

        if($pesquisaCurso === 'todos' || $usuarioLogado->isProfessor()) {
            $pesquisaCurso = 'todos';
        } else {
            $pesquisaCurso = $usuarioLogado->getCurso();
        }

        if($pesquisaCurso && $pesquisaNome) {
            $users = $this->container->usuarioDAO->getByMatriculaNomeCursoSemAcentoARRAY($pesquisaNome, $pesquisaCurso);
        } elseif($pesquisaCurso) {
            $users = $this->container->usuarioDAO->getAllByCursoARRAY($pesquisaCurso);
        } elseif($pesquisaNome) {
            $users = $this->container->usuarioDAO->getByMatriculaNomeARRAY($pesquisaNome);
        } else {
            $users = $todosUsuarios;
        }

        $this->container->view['haPesquisaPorCursoEspecifico'] = $pesquisaCurso !== 'todos';

        $this->container->view['users'] = $users;
        $this->container->view['todosUsuarios'] = $todosUsuarios;
        $this->container->view['usuarioLogado'] = $usuarioLogado;
        $this->container->view['pesquisaNome'] = $pesquisaNome;


        return $this->container->view->render($response, 'listUsersForComparison.tpl');
    }   
    
    public function seeComparison(Request $request, Response $response, $args)
    {
        $alunos = $request->getParsedBodyParam('user');
        $grupoAlunos = [];
        $grupoAlunosTotal = [];
        $nomesAlunos = [];

        if (count($alunos) > 5) {
            $this->container->view['users'] = $this->container->usuarioDAO->getAllARRAY();
            $this->container->view['usuarioLogado'] = $this->container->usuarioDAO->getUsuarioLogado();
            $this->container->view['haPesquisaPorCursoEspecifico'] = false;
            $this->container->view['pesquisaNome'] = false;
            $this->container->view['error'] = "Você deve selecionar até <b>5</b> usuários. Número de usuários selecionados: <b>" . count($alunos) . "</b>";
            return $this->container->view->render($response, 'listUsersForComparison.tpl');
        }


        foreach ($alunos as $index => $aluno) {
            $alunos[$index] = $this->container->usuarioDAO->getById($aluno);
            $grupoAlunos[$index] = Helper::getGruposComPontuacao($this->container, $alunos[$index]);
            $grupoAlunosTotal[$index] = Helper::getGruposComPontuacao($this->container, $alunos[$index], true);

            $nomesAlunos[] = $alunos[$index]->getNome();
        }

        $maiorIra = $alunos[0];
        $grupos = array_keys($grupoAlunos[0]);

        foreach ($alunos as $index => $aluno) {
            if ($aluno->getIra() > $maiorIra->getIra()) {
                $maiorIra = $aluno;
            }
        }

        $maiorAlunoPorGrupo = [];
        foreach ($grupos as $grupo) {
            $maiorAlunoPorGrupo[$grupo] = $this->getTopAlunoNoGrupo($grupoAlunos, $grupo);
        }

        $this->container->view['alunos'] = $alunos;
        $this->container->view['maiorIra'] = $maiorIra;
        $this->container->view['grupoAlunos'] = $grupoAlunos;
        $this->container->view['nomesAlunos'] = $nomesAlunos;
        $this->container->view['grupoAlunosTotal'] = $grupoAlunosTotal;
        $this->container->view['maiorAlunoPorGrupo'] = $maiorAlunoPorGrupo;

        return $this->container->view->render($response, 'seeComparison.tpl');
    }

    public function getTopAlunoNoGrupo($grupoAlunos, $grupo)
    {
        $topAluno = 0;

        foreach ($grupoAlunos as $idAluno => $grupos) {
            if ($grupoAlunos[$idAluno][$grupo] > $grupoAlunos[$topAluno][$grupo]) {
                $topAluno = $idAluno;
            }
        }

        return $topAluno;
    }


    public function manualCoordenador(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'manualCoordenador.tpl');
    }
}