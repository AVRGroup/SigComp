<?php

namespace App\Controller;

use App\Library\CalculateAttributes;
use App\Library\Helper;
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

        if(!$user->isAluno()) {
            return $response->withRedirect($this->container->router->pathFor('adminListReviewCertificates'));
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
        CalculateAttributes::calculateUsuarioStatistics($usuario, $this->container);

        $top10Ira = $this->container->usuarioDAO->getTop10IraTotal();
        $top10IraPeriodoPassado = $this->container->usuarioDAO->getTop10IraPeriodo();

        $notificacoes = $this->container->usuarioDAO->getConvitesPendentes($usuario->getId());


        $this->container->view['medalhas'] = $medalhasUsuario;
        $this->container->view['todasMedalhas'] = $todasMedalhas;
        $this->container->view['usuario'] = $usuario;
        $this->container->view['top10Ira'] = $top10Ira;
        $this->container->view['top10IraPeriodoPassado'] = $top10IraPeriodoPassado;
        $this->container->view['periodoAtual'] = $this->getPeriodoAtual();
        $this->container->view['posicaoGeral'] = $this->container->usuarioDAO->getPosicaoAluno($user->getId());
        $this->container->view['xpTotal'] = $this->container->usuarioDAO->getQuantidadeDisciplinasByGrade($user->getGrade(), $user->getCurso()) * 100;
        $grupos = $this->getGruposComPontuacao($user);
        $this->container->view['grupos'] = $grupos;
        $this->container->view['gruposCursoInteiro'] = $this->getGruposComPontuacao($usuario, true);

        return $this->container->view->render($response, 'home.tpl');
    }

    public function getGruposComPontuacao(Usuario $usuario, $isTotal = false)
    {
        $disciplinas = $this->container->disciplinaDAO->getByGrade($usuario->getGradeId($this->container));
        $quantidadeDeDisciplinasRealizadasNoCurso = [];

        foreach ($disciplinas as $disciplina) {
            $grupo = $disciplina->getGrupo($this->container, $usuario->getCurso());
            if(!isset($grupo)) {
                continue;
            }

            $nomeGrupo = $grupo->getNomeInteiro();
            if(!isset($quantidadeDeDisciplinasRealizadasNoCurso[$nomeGrupo])) {
                $quantidadeDeDisciplinasRealizadasNoCurso[$nomeGrupo] = 0;
            } else {
                $quantidadeDeDisciplinasRealizadasNoCurso[$nomeGrupo] += 1;
            }
        }


        $gruposComPontuacao = [];
        $quantidadeDeDisciplinasRealizadasNoGrupo = [];

        $grupos = $this->container->grupoDAO->getAllByCurso($usuario->getCurso());
        foreach ($grupos as $grupo) {
            $nomeGrupo = $grupo->getNomeInteiro();
            $gruposComPontuacao[$nomeGrupo] = 0;
            $quantidadeDeDisciplinasRealizadasNoGrupo[$nomeGrupo] = 0;
        }

        $gruposComPontuacao["3-Multidisciplinaridade"] = 0;
        $quantidadeDeDisciplinasRealizadasNoGrupo["3-Multidisciplinaridade"] = 0;

        $notas = $usuario->getNotas();

        foreach ($notas as $nota) {
            $disciplina = $nota->getDisciplina();

            if($nota->getEstado() == "Matriculado" || $nota->getEstado() == "Trancado" || $nota->getEstado() == "Rep Nota" || $nota->getEstado() == "Reprovado" || $nota->getEstado() == "Rep Freq" || $nota->getEstado() == "Sem Conceito") {
                continue;
            }
            $grupo = $disciplina->getGrupo($this->container, $usuario->getCurso());

            if(isset($grupo)) {
                $nomeGrupo = $grupo->getNomeInteiro();
                $gruposComPontuacao[$nomeGrupo] += $nota->getValor();
                $quantidadeDeDisciplinasRealizadasNoGrupo[$nomeGrupo] += 1;
            } else {
                $gruposComPontuacao["3-Multidisciplinaridade"] += $nota->getValor();
                $quantidadeDeDisciplinasRealizadasNoGrupo["3-Multidisciplinaridade"] += 1;
            }

        }

        $quantidadeDeDisciplinasRealizadasNoCurso['3-Multidisciplinaridade'] = $quantidadeDeDisciplinasRealizadasNoGrupo['3-Multidisciplinaridade'];

        foreach ($gruposComPontuacao as $grupo => $valor) {

            if( $quantidadeDeDisciplinasRealizadasNoGrupo[$grupo] > $quantidadeDeDisciplinasRealizadasNoCurso[$grupo]) {
                $quantidadeDeDisciplinasRealizadasNoCurso[$grupo] = $quantidadeDeDisciplinasRealizadasNoGrupo[$grupo];
            }

            if ($isTotal) {
                if($quantidadeDeDisciplinasRealizadasNoCurso[$grupo] == 0) {
                    $gruposComPontuacao[$grupo] = 0;
                }
                else {
                    $gruposComPontuacao[$grupo] = $valor / $quantidadeDeDisciplinasRealizadasNoCurso[$grupo];
                }

            } else {
                if ($quantidadeDeDisciplinasRealizadasNoGrupo[$grupo] == 0) {
                    $gruposComPontuacao[$grupo] = 0;
                } else {
                    $gruposComPontuacao[$grupo] = $valor / $quantidadeDeDisciplinasRealizadasNoGrupo[$grupo];
                }
            }

        }

        ksort($gruposComPontuacao);

        foreach ($gruposComPontuacao as $nomeGrupo => $valor) {
            $nomeSemHifen = explode("-", $nomeGrupo)[1];

            $gruposComPontuacao[$nomeSemHifen] = $valor;

            unset($gruposComPontuacao[$nomeGrupo]);
        }

        return $gruposComPontuacao;
    }

    public function abreviaNome($nome, $tamanhoMax){
        $deveAbreviar = true;

        while($deveAbreviar){

            $indicePrimeiraLetra = $this->indicePrimeiraLetraSobrenome($nome, 1);
            $indiceUltimaLetra =  $this->indiceUltimaLetraSobrenome($nome, 1);
            $tamanhoNome = $indiceUltimaLetra - $indicePrimeiraLetra;

            $nome[$indicePrimeiraLetra + 1] = '.';
            $nome = substr_replace($nome, '', $indicePrimeiraLetra + 2, $tamanhoNome - 1);

            $deveAbreviar = false;
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
