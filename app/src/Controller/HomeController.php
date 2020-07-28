<?php

namespace App\Controller;

use App\Library\CalculateAttributes;
use App\Library\Helper;
use App\Library\Integra\isValidProfile;
use App\Model\Disciplina;
use App\Model\Nota;
use App\Model\Usuario;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function indexAction(Request $request, Response $response, $args)
    {
        /** @var Usuario $user */
        $user = $request->getAttribute('user');

        if($user->isProfessor()) {
            return $response->withRedirect($this->container->router->pathFor('adminListUsers'));
        }

        if($user->isBolsista()) {
            return $response->withRedirect($this->container->router->pathFor('adminListReviewCertificates'));
        }

        if($user->isCoordenador() || $user->isAdmin()){
            return $response->withRedirect($this->container->router->pathFor('adminDashboard'));
        }

        if($user->getPrimeiroLogin() == 1) {
            $user->setPrimeiroLogin(0);
            $user->setNomeReal(true);
            $this->container->usuarioDAO->save($user);

            return $this->container->view->render($response, 'politicaPrivacidade.tpl');
        }

        if ($request->isPost()) {

            $pesquisa = $request->getParsedBodyParam('pesquisa');

            try {
                if($pesquisa){
                    $this->container->view['usuariosPesquisados'] = $this->container->usuarioDAO->getByNomeComAmizadeSemAcento($pesquisa, $user->getId());
                }
                else {
                    $newPhotoBase64 = $request->getParsedBodyParam('newPhoto');
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
            } catch (\Exception $e) {
                echo $e->getTraceAsString();
            }
        }

        $usuario = $this->container->usuarioDAO->getByIdFetched($user->getId());
        $medalhasUsuario = $this->container->usuarioDAO->getMedalsByIdFetched($user->getId());
        $todasMedalhas = $this->container->usuarioDAO->getTodasMedalhas();

        $top10Ira = $this->container->usuarioDAO->getTop10IraTotalPorCurso($usuario->getCurso());
        $top10IraPeriodoPassado = $this->container->usuarioDAO->getTop10IraPeriodoPorCurso($usuario->getCurso());

        $notificacoes = $this->container->usuarioDAO->getConvitesPendentes($usuario->getId());


        $this->container->view['medalhas'] = $medalhasUsuario;
        $this->container->view['todasMedalhas'] = $todasMedalhas;
        $this->container->view['usuario'] = $usuario;
        $this->container->view['top10Ira'] = $top10Ira;
        $this->container->view['top10IraPeriodoPassado'] = $top10IraPeriodoPassado;
        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['periodoPassado'] = $this->getPeriodoPassado();
        $this->container->view['posicaoGeral'] = $this->container->usuarioDAO->getPosicaoAluno($user->getId());
        $this->container->view['xpTotal'] = $this->container->usuarioDAO->getQuantidadeDisciplinasByGrade($user->getGrade(), $user->getCurso()) * 100;
        $this->container->view['grupos'] = Helper::getGruposComPontuacao($this->container, $user);;
        $this->container->view['gruposCursoInteiro'] = Helper::getGruposComPontuacao($this->container, $user, true);

        return $this->container->view->render($response, 'home.tpl');
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
        $periodo = $this->container->usuarioDAO->getPeriodCurrent();
        return $periodo;
    }

    public function aboutAction(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'about.tpl');
    }

    public function phpInfoAction(Request $request, Response $response, $args)
    {
        phpinfo();
        //return $this->container->view->render($response, 'about.tpl');

    }

    public function privacidadeAction(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'politicaPrivacidade.tpl');
    }

    public function testAction(Request $request, Response $response, $args)
    {
        set_time_limit(60 * 60);
        $data = Helper::processCSV('/Users/matheus/Desktop/lidiane/dados_alunos_35A1510690190786.csv');

        foreach ($data['disciplinas'] as $disc) {
            $disciplina = new Disciplina();
            $disciplina->setCodigo($disc['codigo']);
            $disciplina->setCarga($disc['carga']);
            $this->container->disciplinaDAO->persist($disciplina);
        }
        $this->container->disciplinaDAO->flush();

        $disciplinas = Helper::convertToIdArray($this->container->disciplinaDAO->getAll());

        foreach ($data['usuarios'] as $user) {
            $usuario = new Usuario();
            $usuario->setCurso($user['curso']);
            $usuario->setMatricula($user['matricula']);
            $usuario->setNome($user['nome']);
            $usuario->setGrade($user['grade']);

            foreach ($user['disciplinas'] as $disc) {
                $nota = new Nota();
                $nota->setEstado($disc['status']);
                $nota->setValor($disc['nota']);
                $nota->setDisciplina($disciplinas[$disc['codigo']]);
                $usuario->addNota($nota);

                $this->container->notaDAO->persist($nota);
            }

            $this->container->usuarioDAO->save($usuario);
        }
        return $this->container->view->render($response, 'home.tpl');
    }


}
