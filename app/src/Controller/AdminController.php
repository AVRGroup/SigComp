<?php

namespace App\Controller;

require __DIR__ . '/../../../vendor/autoload.php';

use App\Library\Helper;
use App\Model\Disciplina;
use App\Model\Grade;
use App\Model\GradeDisciplina;
use App\Model\Nota;
use App\Model\Usuario;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Utility\IdentifierFlattener;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Dompdf\Dompdf;

class AdminController
{

    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function dataLoadAction(Request $request, Response $response, $args)
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
                        set_time_limit(60 * 60); //Should not Exit
                        $data = Helper::processCSV($uploadedFile->file);
                        $affectedData = ['disciplinasAdded' => 0, 'usuariosAdded' => 0, 'usuariosUpdated' => 0];
                        $disciplinas = Helper::convertToIdArray($this->container->disciplinaDAO->getAll());
                        foreach ($data['disciplinas'] as $disc) {
                            if (isset($disciplinas[$disc['codigo']])) {
                                continue;
                            }
                            $disciplina = new Disciplina();
                            $disciplina->setCodigo($disc['codigo']);
                            $disciplina->setCarga($disc['carga']);
                            $this->container->disciplinaDAO->persist($disciplina);
                            $disciplinas[$disciplina->getIdentifier()] = $disciplina; //Added to existing Disciplinas
                            $affectedData['disciplinasAdded']++;
                        }
                        $this->container->disciplinaDAO->flush(); //Commit the transaction
                        $usuarios = Helper::convertToIdArray($this->container->usuarioDAO->getAllFetched());
                        foreach ($data['usuarios'] as $user) {
                            if (isset($usuarios[$user['matricula']])) {
                                $usuario = $usuarios[$user['matricula']];
                                foreach ($usuario->getNotas() as $userNota) {
                                    $usuario->removeNota($userNota);
                                    $this->container->notaDAO->remove($userNota);
                                }
                                $usuario->setNome($user['nome']);
                                $usuario->setGrade($user['grade']);
                                $affectedData['usuariosUpdated']++;
                            } else {
                                $usuario = new Usuario();
                                $usuario->setCurso($user['curso']);
                                $usuario->setMatricula($user['matricula']);
                                $usuario->setNome($user['nome']);
                                $usuario->setGrade($user['grade']);
                                $this->container->usuarioDAO->persist($usuario);
                                $affectedData['usuariosAdded']++;
                            }
                            foreach ($user['disciplinas'] as $disc) {
                                $nota = new Nota();
                                $nota->setEstado($disc['status']);
                                $nota->setValor($disc['nota']);
                                $nota->setPeriodo($disc['periodo']);
                                $nota->setDisciplina($disciplinas[$disc['codigo']]);
                                $usuario->addNota($nota);
                                $this->container->notaDAO->persist($nota);
                            }
                        }
                        $this->container->usuarioDAO->flush(); //Commit the transaction
                        $this->container->view['affectedData'] = $affectedData;
                        $this->container->view['success'] = true;
                    } catch (\Exception $e) {
                        $this->container->view['error'] = $e->getMessage();
                    }
                }
            }
        }
        $this->container->usuarioDAO->setActiveUsers($this->container->usuarioDAO->getUsersPeriodo(20183));
        $this->calculaIra(true);
        $this->abreviaTodosNomes(false);

        return $this->container->view->render($response, 'adminDataLoad.tpl');
    }

    public function calculaIra($calcularIraPeriodoPassado){

        if($calcularIraPeriodoPassado)
            $usuarios = $this->container->usuarioDAO->getAllFetchedByPeriodoNota(20181);
        else
            $usuarios = $this->container->usuarioDAO->getAllFetched();


        /** @var Usuario $usuario */
        foreach ($usuarios as $usuario){
            $somatorioNotasVezesCargas = 0;
            $somatorioCargas = 0;

            /** @var Nota $nota */
            foreach ($usuario->getNotas() as $nota) {

                if($nota->getEstado() == "Matriculado" || $nota->getEstado() == "Trancado" || $nota->getEstado() == "Dispensado")
                    continue;

                $departamento = substr($nota->getDisciplina()->getCodigo(), 0, 3);

                if($departamento != 'DCC' && $departamento != 'EST' && $departamento != 'MAT' && $departamento != 'FIS')
                    continue;

                $somatorioNotasVezesCargas += $this->calculaNotaVezesCarga($nota);
                $somatorioCargas += $nota->getDisciplina()->getCarga();
            }

            if($somatorioCargas != 0)
                $ira = $somatorioNotasVezesCargas / $somatorioCargas;
            else
                $ira = 0;

            if($calcularIraPeriodoPassado) {
                if ($somatorioCargas >= 60*4)
                    $usuario->setIraPeriodoPassado($ira);
                else
                    $usuario->setIraPeriodoPassado(0);
            }
            else
                $usuario->setIra($ira);

            try {
                $this->container->usuarioDAO->flush();
            }
            catch (\Exception $e) {
                echo $e;
            }
        }
    }

    public function calculaNotaVezesCarga($nota){
        /** @var Nota $nota */

        if($nota->getValor() === 'A')
            return 100 * $nota->getDisciplina()->getCarga();

        if($nota->getValor() === 'B')
            return 90 * $nota->getDisciplina()->getCarga();

        if($nota->getValor() === 'C')
            return 80 * $nota->getDisciplina()->getCarga();

        return $nota->getValor() * $nota->getDisciplina()->getCarga();
    }


    public function abreviaTodosNomes($isPeriodoPassado){

        if($isPeriodoPassado)
            $usuarios = $this->container->usuarioDAO->getAllFetched10PrimeirosPorIraPeriodoPassado();
        else
            $usuarios = $this->container->usuarioDAO->getAllFetched10PrimeirosPorIra();

        /** @var Usuario $usuario */
        foreach ($usuarios as $usuario) {

            $nomeAbreviado =  $this->abreviaNome($usuario->getNome(), 123);

            //echo $nomeAbreviado . ' ';

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
                        set_time_limit(60 * 60); //Should not Exit
                        $data = Helper::processGradeCSV($uploadedFile->file);
                        $affectedData = ['disciplinasAdded' => 0];
                        $grade = new Grade();
                        $grade->setCodigo(12009);
                        $this->container->gradeDAO->persist($grade);
                        $this->container->gradeDAO->flush();
                        $disciplinas = Helper::convertToIdArray($this->container->disciplinaDAO->getAll());
                        $this->container->view['vetor'] = $data;
                        $this->container->view['disciplinas'] = $disciplinas;
                        foreach ($data['disciplinas'] as $disc) {
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
        return $this->container->view->render($response, 'adminGradeLoad.tpl');
    }

    public function adminData(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'data.tpl');
    }

    public function formataSemestre($mesInicio){
        return $mesInicio > 6 ? '3' : '1';
    }

    public function getPeriodoLegivel($certificado) : string {
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

    public function exportPDFAction(){
        $aluno = $this->container->usuarioDAO->getById(87);
        $certificados = $this->container->certificadoDAO->getAllByUsuario($aluno);
        $total_horas = $this->container->certificadoDAO->getTotalHoras($aluno->getId());

//        var_dump($total_horas);
        die();

        $data = date('d M Y');

        $caminhoImagem = realpath(__DIR__ . '/../../../public/img/logo_ufjf.png');

        $html = '<head><meta charset="UTF-8"></head>';
        $html .= '<div align="right"><img width="180" height="100" src='. $caminhoImagem . ' alt=""></div> ';
        $html .= '<div align="right"><p>UNIVERSIDADE FEDERAL DE JUIZ DE FORA<br>INSTITUTO DE CIÊNCIAS EXATAS-ICE<br>CAMPUS UNIVERSITÁRIO – SÃO PEDRO – JUIZ DE FORA – MG<br>CEP: 36036-900 - TEL:(032) 2102-3302 - FAX:(032) 2012-3300</p></div>';
        $html .= '<div align="right"><p>Juiz de Fora, '.$data.'</div>';
        $html .= '<div align="center"><p>PARECER</p></div>';
        $html .= '<div align="justify"><p>Com base na Resolução 03/2014 do Colegiado do Curso de Ciência da Computação, a Coordenação do Curso Noturno de Ciência da Computação apresenta parecer FAVORÁVEL ao pedido do discente '.$aluno->getNome().', matrícula '.$aluno->getMatricula().', e solicita cômputo de <b>'. $total_horas .' horas em atividades curriculares eletivas </b>, referente às atividades a seguir:</p></div>';
        $html .= '<table align="center" style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%; ">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px">Periodo</th>';
        $html .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px">Tipo</th>';
        $html .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px">Horas</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';


        foreach ($certificados as $certificado){

            $periodo = $this->getPeriodoLegivel($certificado);

            $html .= '<tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px">'. $periodo ."</td>";
            $html .= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px">'.$certificado->getNomeTipo(). ": " . $certificado->getNomeImpresso() . "</td>";
            $html .= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px">'.$certificado->getNumHoras(). "</td>" . "</tr>";
        }

        $html .= '</tbody>';
        $html .= '</table>';


        $dompdf = new Dompdf();
        //$html = file_get_contents(__DIR__ . '/../../templates/teste.html');
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("aproveitamento.pdf",
            array(
                "Attachment" => true //Para realizar o download somente alterar para true
            ));
    }



}