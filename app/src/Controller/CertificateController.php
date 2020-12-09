<?php

namespace App\Controller;

use App\Model\Certificado;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use App\Library\MailSender;
use Dompdf\Dompdf;
use Fpdf\Fpdf;
use Clegginabox\PDFMerger\PDFMerger;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class CertificateController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }
    
    public function listAction(Request $request, Response $response, $args)
    {
        if ($request->isPost() && isset($request->getUploadedFiles()['certificate'])) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $request->getUploadedFiles()['certificate'];
            if($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                $this->container->view['error'] = 'Erro no upload do certificado, tente novamente!';
            } else if ($request->getParsedBodyParam('type') == null || !isset(Certificado::getAllTipos()[$request->getParsedBodyParam('type')])){
                $this->container->view['error'] = 'Selecione o tipo de certificado!';
            } else {
                $extension = mb_strtolower(pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION));
                if(!in_array($extension, $this->container->settings['upload']['allowedCertificationExtensions']) || $uploadedFile->getSize() > $this->container->settings['upload']['maxBytesSize']) {
                    $this->container->view['error'] = 'Formato ou Tamanho do certificado inválido!';
                } else {
                    try {
                        $certificado = new Certificado();
                        $certificado->setUsuario($request->getAttribute('user'));
                        $certificado->setExtensao($extension);

                        $tipo = $request->getParsedBodyParam('type');
                        $certificado->setTipo($tipo);

                        $numHoras = $request->getParsedBodyParam('num_horas');

                        $certificado->setNomeImpresso($request->getParsedBodyParam('nome_impresso'));

                        $inicio= new \DateTime($request->getParsedBodyParam('data_inicio'));
                        $certificado->setDataInicio($inicio);

                        $fim = new \DateTime($request->getParsedBodyParam('data_fim'));
                        $certificado->setDataFim($fim);

                        if($request->getParsedBodyParam('data_inicio1') == null)
                            $dataInicio1 = null;
                        else
                            $dataInicio1 = new \DateTime($request->getParsedBodyParam('data_inicio1'));
                        $certificado->setDataInicio1($dataInicio1);

                        if($request->getParsedBodyParam('data_inicio2') == null)
                            $dataInicio2 = null;
                        else
                            $dataInicio2 = new \DateTime($request->getParsedBodyParam('data_inicio2'));
                        $certificado->setDataInicio2($dataInicio2);

                        if($request->getParsedBodyParam('data_fim1') == null)
                            $dataFim1= null;
                        else
                            $dataFim1= new \DateTime($request->getParsedBodyParam('data_fim1'));
                        $certificado->setDataFim1($dataFim1);

                        if($request->getParsedBodyParam('data_fim2') == null)
                            $dataFim2 = null;
                        else
                            $dataFim2 = new \DateTime($request->getParsedBodyParam('data_fim2'));
                        $certificado->setDataFim2($dataFim2);

                        $multiplicadorHoras = $this->multiplicadorHorasCertificado($inicio, $fim);
                        if(isset($dataFim1) && isset($dataInicio1))
                            $multiplicadorHoras += $this->multiplicadorHorasCertificado($dataInicio1, $dataFim1);

                        if(isset($dataFim2) && isset($dataInicio2))
                            $multiplicadorHoras += $this->multiplicadorHorasCertificado($dataInicio2, $dataFim2);

                        $horasTotais = $multiplicadorHoras * $this->maxNumHorasPorPeriodo($numHoras , $tipo);
                        $certificado->setNumHoras($this->maxNumHorasTotal($horasTotais, $tipo));

                        do {
                            $uuid4 = Uuid::uuid4();
                            $certificado->setNome($uuid4->toString() . '.' . $extension); //Make sure we got an unique name
                        } while (file_exists($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome()));

                        $uploadedFile->moveTo($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());

                        $this->container->certificadoDAO->save($certificado);
                        $this->container->certificadoDAO->incrementNumberOfCertificates();

                        $this->container->view['success'] = true;
                    } catch (\Exception $e) {
                        unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());
                        $this->container->view['error'] = $e;
                    }
                }
            }
        }
        $this->container->view['certTypes'] = Certificado::getAllTipos();
        $this->container->view['certificates'] = $this->container->certificadoDAO->getAllByUsuario($request->getAttribute('user'));

        $certificadosValidados = $this->container->certificadoDAO->getValidatedByUsuario($request->getAttribute('user'));
        $this->container->view['horasTotais'] = $this->horasTotais($certificadosValidados);

        return $this->container->view->render($response, 'certificates.tpl');
    }

    public function PdfMerge(Request $request, Response $response, $args)
	{
        $arquivo = 'certificados.zip';

        // Apaga o backup anterior para que ele não seja compactado junto com o atual.
        if (file_exists($arquivo)) unlink(realpath($arquivo)); 

        // diretório que será compactado
        $diretorio = "../public/upload/"; // aqui estou compactando a pasta raiz do sistema.
        $rootPath = realpath($diretorio);

        // Certificados dos alunos
        $aluno = $this->container->usuarioDAO->getUsuarioLogado();
        $certificados = $this->container->certificadoDAO->getValidatedByUsuario($aluno);
        
        // Inicia o Módulo ZipArchive do PHP
        $zip = new ZipArchive();
        $zip->open($arquivo, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Compactação de subpastas
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        // Varre todos os arquivos da pasta
        if(isset($certificados))
        {
            foreach ($certificados as $certificado)
            {
            
                if ($certificado->getValido())
                {                    
                    $filePath = "../public/upload/{$certificado->getNome()}";

                    // Adiciona os arquivos no pacote Zip.
                    $zip->addFile($filePath);
                }
            }
        }
        else
        {
            $redirect = $this->container->router->pathFor('home');
            return $response->withRedirect($redirect);
        }

        // Encerra a criação do pacote .Zip
        $zip->close();

        $arquivo = 'certificados.zip'; // define o nome do pacote Zip gerado na 9
        if(isset($arquivo) && file_exists($arquivo)){ // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
            switch(strtolower(substr(strrchr(basename($arquivo),"."),1))){ // verifica a extensão do arquivo para pegar o tipo
                case "pdf": $tipo="application/pdf"; break;
                case "exe": $tipo="application/octet-stream"; break;
                case "zip": $tipo="application/zip"; break;
                case "doc": $tipo="application/msword"; break;
                case "xls": $tipo="application/vnd.ms-excel"; break;
                case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
                case "gif": $tipo="image/gif"; break;
                case "png": $tipo="image/png"; break;
                case "jpg": $tipo="image/jpg"; break;
                case "mp3": $tipo="audio/mpeg"; break;
                case "php": // deixar vazio por seurança
                case "htm": // deixar vazio por seurança
                case "html": // deixar vazio por seurança
            }
            header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
            header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
            header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
            readfile($arquivo); // lê o arquivo
            exit; // aborta pós-ações
        }
	}


    public function horasTotais($certificados){
        $horas = 0;

        foreach ($certificados as $certificado){
            $horas += $certificado->getNumHoras();
        }

        return $horas;
    }

    public function maxNumHorasTotal($numHoras, $tipo){
        $max120Horas = [Certificado::REPRESENTACAO, Certificado::MONITORIA, Certificado::TP, Certificado::TA, Certificado::IC ];
        $max180Horas = [Certificado::EMP_JUNIOR];
        $max240Horas = [Certificado::VIVENCIA, Certificado::GET];

        if($numHoras > 120 && in_array($tipo, $max120Horas))
            return 120;

        if($numHoras > 180 && in_array($tipo, $max180Horas))
            return 180;

        if($numHoras > 240 && in_array($tipo, $max240Horas))
            return 240;
        
        return $numHoras;
    }

    public function maxNumHorasPorPeriodo($numHoras, $tipo){
        $certificados15Horas = [Certificado::VIVENCIA, Certificado::LING_ENTRANGEIRA ,Certificado::ORG_EVENTO, Certificado::PART_EVENTO, Certificado::APRE_PALESTRA];
        $certificados30Horas = [Certificado::APRE_MINICURSO, Certificado::GRP_ESTUDO, Certificado::CERT_CURSO];
        $certificados60Horas = [Certificado::MONITORIA, Certificado::ESTAGIO, Certificado::REPRESENTACAO, Certificado::EMP_JUNIOR, Certificado::TP, Certificado::TA, Certificado::IC];

        if($numHoras > 15 && in_array($tipo, $certificados15Horas)){
            return 15;
        }

        if($numHoras > 30 && in_array($tipo, $certificados30Horas)){
            return 30;
        }

        if($numHoras > 60 && in_array($tipo, $certificados60Horas)){
            return 60;
        }

        return $numHoras;
    }

    public function multiplicadorHorasCertificado($inicio, $fim){
        $anoInicio = $inicio->format('Y');
        $anoFim = $fim->format('Y');

        $periodoInicio = $this->formataSemestre($inicio->format('m'));
        $periodoFim = $this->formataSemestre($fim->format('m'));

        $multiplicador = $anoFim - $anoInicio + 1;

        if($periodoFim > $periodoInicio)
            $multiplicador += 1;

        return $multiplicador;
    }

    public function formataSemestre($mes){
        return $mes > 6 ? '3' : '1';
    }

    public function deleteAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);

        if($certificado && $certificado->getUsuario()->getId() == $request->getAttribute('user')->getId()
            && ($certificado->isInReview() || !$certificado->getValido())) {
            $this->container->certificadoDAO->delete($certificado);
            unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());
        }

        return $response->withRedirect($this->container->router->pathFor('listCertificates'));
    }

    // Administração

    public function adminListReviewAction(Request $request, Response $response, $args)
    {
        $certificates = $this->container->certificadoDAO->getAllToReview();
        
        $curso = $this->container->usuarioDAO->getUsuarioLogado();
        $curso = $curso->getCurso();

        $certificadosFiltrados = [];
        
        foreach($certificates as $certificate)
        {
            if($certificate->getUsuario()->getCurso() == $curso)
            {
                $certificadosFiltrados[] = $certificate;
            }
        }
        $this->container->view['certificates'] = $certificadosFiltrados;
        $this->container->view['certTypes'] = Certificado::getAllTipos();
        return $this->container->view->render($response, 'adminCertificates2.tpl');
    }


    public function adminDeleteAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);

        if($certificado) {
            $this->container->certificadoDAO->delete($certificado);
            unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $certificado->getNome());
            $redirect = $this->container->router->pathFor('adminUser', ['id' => $certificado->getUsuario()->getId()]);
        } else {
            $redirect = $this->container->router->pathFor('adminListUsers');
        }

        if(!is_null($request->getQueryParam('isReviewPage')))
            $redirect = $this->container->router->pathFor('adminListReviewCertificates');

        return $response->withRedirect($redirect);
    }

    public function adminRefuseAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);
        if($certificado) {
            try {
                $certificado->setValido(false);
                $this->container->certificadoDAO->persist($certificado);
                $this->container->certificadoDAO->flush();

                $redirect = $this->container->router->pathFor('adminListReviewCertificates');
            }
            catch (\Exception $e) {
                die(var_dump($e));
            }
        }
        else {
            $redirect = $this->container->router->pathFor('adminListUsers');
        }

        return $response->withRedirect($redirect);
    }

    public function adminAcceptAction(Request $request, Response $response, $args)
    {
        $certificado = $this->container->certificadoDAO->getById($args['id']);

        if($certificado) {
            $this->updateCertificateFields($request);
            $redirect = $this->container->router->pathFor('adminListReviewCertificates');

        } else {
            $redirect = $this->container->router->pathFor('adminListUsers');
        }

        if(!is_null($request->getQueryParam('isReviewPage')))
            $redirect = $this->container->router->pathFor('adminListReviewCertificates');

        return $response->withRedirect($redirect);
    }

    public function updateCertificateFields(Request $request)
    {
        try {
            $certificado = $this->container->certificadoDAO->getById($request->getParsedBodyParam("id"));

            $tipo = $request->getParsedBodyParam("type");
            $numHoras = $request->getParsedBodyParam("num_horas");
            $nomeImpresso = $request->getParsedBodyParam("nome_impresso");
            $dataInicio = date_create($request->getParsedBodyParam("data_inicio"));
            $dataFim = date_create($request->getParsedBodyParam("data_fim"));

            if ($request->getParsedBodyParam("data_inicio1") != null) {
                $dataInicio1 = date_create($request->getParsedBodyParam("data_inicio1"));
                $dataFim1 = date_create($request->getParsedBodyParam("data_fim1"));

                $certificado->setDataInicio1($dataInicio1);
                $certificado->setDataFim1($dataFim1);

            }

            if ($request->getParsedBodyParam("data_inicio2") != null) {
                $dataInicio2 = date_create($request->getParsedBodyParam("data_inicio2"));
                $dataFim2 = date_create($request->getParsedBodyParam("data_fim2"));

                $certificado->setDataInicio2($dataInicio2);
                $certificado->setDataFim2($dataFim2);
            }

            $certificado->setTipo($tipo);
            $certificado->setNumHoras($numHoras);

            $certificado->setNomeImpresso($nomeImpresso);
            $certificado->setDataInicio($dataInicio);
            $certificado->setDataFim($dataFim);

            $certificado->setValido(true);

            $this->container->certificadoDAO->persist($certificado);
            $this->container->certificadoDAO->flush();
        }
        catch (\Exception $e) {
            die(var_dump($e));
        }
    }

    public function sendMailAction(Request $request, Response $response, $args)
    {
        $mail = new MailSender();

        $quantidadeCertificados = $this->container->certificadoDAO->getNumberOfCertificates();
        $quantidadeCertificados = intval($quantidadeCertificados[0]['quantidade_certificados']);

        if($quantidadeCertificados >= 1) {
            $mail->sendMail($quantidadeCertificados);
            $this->container->certificadoDAO->setNumberOfCertificates();
            return "EMAIL ENVIADO";
        }

        return "EMAIL NÂO ENVIADO";
    }

}
