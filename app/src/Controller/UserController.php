<?php

namespace App\Controller;

use App\Library\CalculateAttributes;
use App\Library\Helper;
use App\Library\Integra\getUserInformation;
use App\Library\Integra\getUserInformationResponse;
use App\Library\Integra\login;
use App\Library\Integra\logout;
use App\Library\Integra\WSLogin;
use App\Library\Integra\wsUserInfoResponse;
use App\Model\Certificado;
use App\Model\Nota;
use App\Model\Usuario;
use App\Model\GradeDisciplina;
use App\Model\Grade;
use App\Persistence\UsuarioDAO;
use App\Persistence\TurmaDAO;
use App\Persistence\ProfessorTurmaDAO;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;
use GuzzleHttp\Client;

class UserController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function adminListAction(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();

        $curso = null;
        $parametro = $request->getParam('curso');
        $pesquisa = null;

        if ($usuario->isCoordenador()) {
            $curso = $usuario->getCurso();
        }
        elseif(isset($parametro)) {
            $curso = $parametro;
        }

        if ($usuario->isProfessor()) {
            $this->container->view['users'] = $this->container->usuarioDAO->getAllARRAY();
        }

        if($request->getParam('pesquisa')){
            $pesquisa = $request->getParam('pesquisa');
            $this->container->view['users'] = $this->container->usuarioDAO->getByMatriculaNomeCursoSemAcentoARRAY($pesquisa, $curso);

        }

        else {
            $this->container->view['users'] = $this->container->usuarioDAO->getAllByCursoARRAY($curso);
        }


        $this->container->view['pesquisa'] = $pesquisa;
        $this->container->view['curso'] = $curso;

        return $this->container->view->render($response, 'adminListUsers.tpl');
    }

    public function visualizarAmigoAction(Request $request, Response $response, $args)
    {
        $amigo = $this->container->usuarioDAO->getByIdFetched($args['id']);
        $usuarioLogado = $this->container->usuarioDAO->getUsuarioLogado();

        if(!$amigo) {
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        $medalhasUsuario = $this->container->usuarioDAO->getMedalsByIdFetched($amigo->getId());

        $this->container->view['visaoAmigo'] = true;
        $this->container->view['usuario'] = $amigo;
        $this->container->view['medalhas'] = $medalhasUsuario;
        $this->container->view['posicaoGeral'] = $this->container->usuarioDAO->getPosicaoAluno($amigo->getId());
        $this->container->view['todasMedalhas'] =  $this->container->usuarioDAO->getTodasMedalhas();;
        $this->container->view['top10Ira'] = $this->container->usuarioDAO->getTop10IraTotal();
        $this->container->view['top10IraPeriodoPassado'] = $this->container->usuarioDAO->getTop10IraPeriodo();
        $this->container->view['naoBarraPesquisa'] = true;
        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['xpTotal'] = $this->container->usuarioDAO->getQuantidadeDisciplinasByGrade($amigo->getGrade(), $amigo->getCurso()) * 100;

        $this->container->view['grupos'] = Helper::getGruposComPontuacao($this->container, $amigo);;
        $this->container->view['gruposCursoInteiro'] = Helper::getGruposComPontuacao($this->container, $amigo, true);
        $this->container->view['gruposUsuarioLogado'] = Helper::getGruposComPontuacao($this->container, $usuarioLogado);

        return $this->container->view->render($response, 'home.tpl');
    }

    public function getPeriodoAtual()
    {
        $ultimaCarga = explode("-", $this->container->usuarioDAO->getPeriodoCorrente());
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

    public function adminTestAction(Request $request, Response $response, $args)
    {
        $allUsers = $this->container->usuarioDAO->getAllFetched();

        /** @var Usuario $user */
        foreach ($allUsers as $user) {
            $exp = 0;
            /** @var Nota $notas */
            foreach ($user->getNotas() as $notas) {
                $exp += $notas->getValor();
            }

            $user->setExperiencia($exp);
        }

        $this->container->usuarioDAO->flush();

        $this->container->view['usuariosFull'] = $allUsers;

        return $this->container->view->render($response, 'adminTest.tpl');
    }


    public function informacoesPessoaisAction(Request $request, Response $response, $args)
    {
        $user = $request->getAttribute('user');
        $usuario = $this->container->usuarioDAO->getByIdFetched($user->getId());

        try {
            if ($request->isPost()) {
                $email = $request->getParsedBodyParam('email');
                $facebook = $request->getParsedBodyParam('facebook');
                $instagram = $request->getParsedBodyParam('instagram');
                $linkedin = $request->getParsedBodyParam('linkedin');
                $lattes = $request->getParsedBodyParam('lattes');
                $sobreMim = $request->getParsedBodyParam('sobre_mim');
                $nomeReal = $request->getParsedBodyParam('nome_real');

                if($nomeReal == 'on') {
                    $usuario->setNomeReal(0);
                } else {
                    $usuario->setNomeReal(1);
                }

                if(isset($email)) {
                    $usuario->setEmail($email);
                }

                $redesComErro = $this->getRedesComErro($facebook, $instagram, $linkedin, $lattes);

                if(in_array("Facebook", $redesComErro)) {
                    $usuario->setFacebook(null);
                } elseif(isset($facebook)) {
                    $usuario->setFacebook($facebook);
                }

                if(in_array("Instagram", $redesComErro)) {
                    $usuario->setInstagram(null);
                } elseif(isset($instagram)) {
                    $usuario->setInstagram($instagram);
                }

                if(in_array("Linkedin", $redesComErro)) {
                    $usuario->setLinkedin(null);
                } elseif(isset($linkedin)) {
                    $usuario->setLinkedin($linkedin);
                }

                if(in_array("Lattes", $redesComErro)) {
                    $usuario->setLattes(null);
                } else {
                    $usuario->setLattes($lattes);
                }

                $this->container->view['errors'] = $redesComErro;

                $newPhotoBase64 = $request->getParsedBodyParam('newPhoto');

                if(isset($newPhotoBase64)) {
                    list(, $data) = explode(',', $newPhotoBase64);
                    $newPhoto = base64_decode($data);

                    $im = imagecreatefromstring($newPhoto);
                    if ($im !== false) {
                        $lastFoto = $user->getFoto();

                        do {
                            $uuid4 = Uuid::uuid4();
                            $user->setFoto($uuid4->toString() . '.png'); //Make sure we got an unique name
                        } while (file_exists($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $user->getFoto()));

                        file_put_contents($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $user->getFoto(),
                            $newPhoto);

                        $this->container->usuarioDAO->save($user);
                        imagedestroy($im);

                        //Delete Last Foto
                        if ($lastFoto) {
                            unlink($this->container->settings['upload']['path'] . DIRECTORY_SEPARATOR . $lastFoto);
                        }
                    }
                }

                if(isset($sobreMim)) {
                    $usuario->setSobremim($sobreMim);
                }

                $this->container->usuarioDAO->persist($usuario);
                $this->container->usuarioDAO->flush(); //Commit the transaction
                $this->container->view['success'] = "Informações atualizadas com sucesso";
            }
        }
        catch (\Exception $e){
            $this->container->view['errors'] = $e->getMessage();
        }

        $this->container->view['usuario'] = $usuario;

        if($usuario->getNomeReal())
            $this->container->view['checked'] = "";
        else
            $this->container->view['checked'] = "checked";


        return $this->container->view->render($response, 'informacoesPessoais.tpl');
    }

    public function getRedesComErro($face = null, $insta = null, $linkedin = null, $lattes = null){

        $redesComErro = [];

        if($face != null && strpos($face, "facebook.com") === false){
            $redesComErro[] = 'Facebook';
        }

        if($insta != null && strpos($insta, "instagram.com") === false){
            $redesComErro[] = 'Instagram';
        }

        if($linkedin != null && strpos($linkedin, "linkedin.com") === false){
            $redesComErro[] = 'Linkedin';
        }

        if($lattes != null && strpos($lattes, "cnpq") === false){
            $redesComErro[] = 'Lattes';

        }

        return $redesComErro;
    }

    public function periodMedalsVerification(Grade $grade, $periodo){
        $users = $this->container->usuarioDAO->getUsersNotasByGrade($grade->getCodigo(), $grade->getCurso());
        $disciplinas = $this->container->usuarioDAO->getDisciplinasByGradePeriodo($grade->getCodigo(), $periodo, $grade->getCurso());

        if(is_null($disciplinas)) {
            return null;
        }

        $cont = 0;

        unset($usrs);
        $usrs = array();

        foreach ($users as $user){
            $user_notas = $user->getNotas();
            foreach ($disciplinas as $disciplina){
                foreach ($user_notas as $un){
                    if ($disciplina->getCodigo() == $un->getDisciplina()->getCodigo())
                        $cont++;
                    else if ($un->getDisciplina()->getCodigo() == $disciplina->getCodigo()."E")
                        $cont++;
                }
            }
            if(sizeof($disciplinas) > 0){
                if ($cont == sizeof($disciplinas)){
                    array_push($usrs, $user);
                }
                $cont = 0;
            }
        }
        return $usrs;
    }


    public function conviteAmizadeAction(Request $request, Response $response, $args){
        $this->container->usuarioDAO->setConviteAmizade($args['id-remetente'], $args['id-destinatario']);

        return $response->withRedirect($this->container->router->pathFor('home'));
    }


    public function teste(Request $request, Response $response, $args){
        $periodoCorrente = $this->container->usuarioDAO->getPeriodoCorrente();
        $periodo = $this->container->usuarioDAO->getUsersPeriodoAtual(145, $periodoCorrente);

        die(var_dump($periodo));
    }


    public function aceitarConviteAction(Request $request, Response $response, $args){
        $this->container->usuarioDAO->aceitarConvite($args['id-remetente'], $args['id-destinatario']);

        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function listarAmigosAction(Request $request, Response $response, $args){

        $amigos = $this->container->usuarioDAO->getAmigos($args['id']);
        $user = $request->getAttribute('user');


        $medalhasAmigo = [];
        foreach ($amigos as $amigo) {
            $medalhasAmigo[] = $this->container->usuarioDAO->getMedalsByIdFetched($amigo['id']);
        }



        $this->container->view['medalhas'] = $medalhasAmigo;
        $this->container->view['amigos']  = $amigos;

        return $this->container->view->render($response, 'listaAmigos.tpl');
    }

    public function assignMedalsAction(Request $request, Response $response, $args){

        $this->container->medalhaUsuarioDAO->truncateTable();
        $grades = $this->container->gradeDAO->getAll();

        foreach ($grades as $grade) {
            for ($periodo = 1; $periodo <= 9; $periodo++) {
                $usuarios = $this->periodMedalsVerification($grade, $periodo);
                if($usuarios) {
                    $this->container->usuarioDAO->setPeriodo($usuarios, $periodo);
                }
            }
        }

        $this->container->usuarioDAO->setByIRA($this->container->usuarioDAO->getByIRA(60, 70), 60);
        $this->container->usuarioDAO->setByIRA($this->container->usuarioDAO->getByIRA(70, 80), 70);
        $this->container->usuarioDAO->setByIRA($this->container->usuarioDAO->getByIRA(80, 100), 80);

        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(2, 3, 12009), 2, 12009);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(3, 4, 12009), 3, 12009);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(4, 5, 12009), 4, 12009);

        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(2, 3, 12014), 2, 12014);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(3, 4, 12014), 3, 12014);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(4, 5, 12014), 4, 12014);

        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(2, 3, 12018), 2, 12018);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(3, 4, 12018), 3, 12018);
        $this->container->usuarioDAO->setByOptativas($this->container->usuarioDAO->getByOptativas(4, 5, 12018), 4, 12018);

        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(1, 2, 12009), 1, 12009);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(2, 3, 12009), 2, 12009);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(3, 4, 12009), 3, 12009);

        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(1, 2, 12014), 1, 12014);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(2, 3, 12014), 2, 12014);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(3, 4, 12014), 3, 12014);

        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(1, 2, 12018), 1, 12018);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(2, 3, 12018), 2, 12018);
        $this->container->usuarioDAO->setBy100($this->container->usuarioDAO->getBy100(3, 4, 12018), 3, 12018);

        $allUserIds = $this->container->usuarioDAO->getAllUsersIds();
        $periodoCorrente = $this->container->usuarioDAO->getPeriodoCorrente();
        foreach ($allUserIds as $userId) {
            $userId = $userId['id'];
            //ficou um pouco confuso, mas o get recebe o tipo do certificado (da model 'Certificado.php') e o set recebe o numero da primeira medalha (da tabela 'medalha')
            $this->container->usuarioDAO->setByNumMedalha($this->container->usuarioDAO->getByTipoCertificado(18, $userId), 22);
            $this->container->usuarioDAO->setByNumMedalha($this->container->usuarioDAO->getByTipoCertificado(19, $userId), 30);
            $this->container->usuarioDAO->setByNumMedalha($this->container->usuarioDAO->getByTipoCertificado(20, $userId), 26);
            $this->container->usuarioDAO->setByNumMedalha($this->container->usuarioDAO->getByTipoCertificado(11, $userId), 36, 1);


            $this->container->usuarioDAO->setTurista($userId);
            $this->container->usuarioDAO->setEstagio($userId);
            $this->container->usuarioDAO->setEmpresaJunior($userId);
            $this->container->usuarioDAO->setPoliglota($userId);
            $this->container->usuarioDAO->setPeriodizado($userId, $periodoCorrente);

            $user = $this->container->usuarioDAO->getById($userId);
            if($user->getSituacao() == 1) {
                $this->container->usuarioDAO->setTodasMedalhasPeriodo($userId);
            }

        }

        return $this->container->view->render($response, 'assignMedals.tpl');
        //return $this->container->view->render($response, 'checkPeriodos.tpl');
    }

    public function editarCoordenadores(Request $request, Response $response, $args){
        $professores = $this->container->usuarioDAO->getProfessores();
        $this->container->view['professores'] = $professores;
        $coordenadores = $this->container->usuarioDAO->getCoordenador();
        $this->container->view['coordenadores'] = $coordenadores;

        return $this->container->view->render($response, 'selectCoordenadores.tpl');
    }

    public function storeEditCoord(Request $request, Response $response, $args){
        $coordenadores = $this->container->usuarioDAO->getCoordenador();
        $professores = $this->container->usuarioDAO->getProfessores();
        $this->container->view['professores'] = $professores;

        #Checa as exclusoes de coordenadores
        foreach( $coordenadores as $coordenador ){
            if( isset($_POST["exclui_" . $coordenador->getId()] )){
                echo "<script>console.log('CHAMA ESCLUSAO');</script>";
                $coordenador->setTipo(4);
                $this->container->usuarioDAO->setProfessor($coordenador->getId());
            }
        }

        #Seleciona os coordenadores
        foreach ( $professores as $professor ){
            if(isset($_POST["coord_" . $professor->getId()])){
                if( $this->checaCoord($request, $response, $args )) {
                    $professor->setTipo(2);
                    $this->container->usuarioDAO->setCoordenador($professor->getId());
                } else {
                    $this->container->view['incompleto'] = "Não podem haver mais de 4 coordenadores!";
                    return $this->editarCoordenadores($request, $response, $args, 'selectCoordenadores.tpl');
                }
            }
        }
        $this->container->view['completo'] = "Alterações salvas com sucesso!";
        return $this->editarCoordenadores($request, $response, $args, 'selectCoordenadores.tpl');
    }

    public function checaCoord(Request $request, Response $response, $args){
        $coordenadores = $this->container->usuarioDAO->getCoordenador();
        $cont = 0;
        
        foreach( $coordenadores as $coordenador ){
            $cont += 1;
        }
        if ( $cont < 4 ){
            return true;
        } else {
            return false;
        }
    }

    public function infoRadarChart(Request $request, Response $response, $args)
    {
        $usuario = $this->container->usuarioDAO->getUsuarioLogado();

        $disciplinas = $this->container->disciplinaDAO->getByGrade($usuario->getGradeId($this->container));

        $this->container->view['disciplinas'] = $disciplinas;
        $this->container->view['curso'] = $usuario->getCurso();
        $this->container->view['container'] = $this->container;

        return $this->container->view->render($response, 'infoRadarChart.tpl');
    }

    public function testeServico(Request $request, Response $response, $args){

        $testeArray = array();

        $testeArray['Key 1'] = " 1 Value";
        $testeArray['Key 2'] = " 2 Value";
        $testeArray['Key 3'] = " 3 Value";

        $this->container->view['keys'] = array_keys($testeArray);
        $this->container->view['values'] = array_values($testeArray);

        return $this->container->view->render($response, 'testeServico.tpl');	
    }

    public function indexTesteServico(Request $request, Response $response, $args){	
        
        return $this->container->view->render($response, 'testeServico.tpl');	
    }
}

