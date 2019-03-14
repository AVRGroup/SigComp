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
        $this->container->view['notificacoes'] = $this->container->usuarioDAO->getConvitesPendentes($user->getId()) ;

        if($user->getPrimeiroLogin() == 1) {
            $user->setPrimeiroLogin(0);
            $this->container->usuarioDAO->save($user);

            return $this->container->view->render($response, 'politicaPrivacidade.tpl');
        }

        if ($request->isPost()) {

            $pesquisa = $request->getParsedBodyParam('pesquisa');

            try {
                if($pesquisa){
                    $this->container->view['usuariosPesquisados'] = $this->container->usuarioDAO->getByNomeComAmizade($pesquisa, $user->getId());

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
                // TODO Error message
            }
        }

        $usuario = $this->container->usuarioDAO->getByIdFetched($user->getId());
        $medalhasUsuario = $this->container->usuarioDAO->getMedalsByIdFetched($user->getId());
        $todasMedalhas = $this->container->usuarioDAO->getTodasMedalhas();
        CalculateAttributes::calculateUsuarioStatistics($usuario);

        $top10Ira = $this->container->usuarioDAO->getTop10IraTotal();
        $top10IraPeriodoPassado = $this->container->usuarioDAO->getTop10IraPeriodo();


        $this->container->view['medalhas'] = $medalhasUsuario;
        $this->container->view['todasMedalhas'] = $todasMedalhas;
        $this->container->view['usuario'] = $usuario;
        $this->container->view['top10Ira'] = $top10Ira;
        $this->container->view['top10IraPeriodoPassado'] = $top10IraPeriodoPassado;
        $this->container->view['notificacoes'] =  $this->container->usuarioDAO->getConvitesPendentes($usuario->getId());


        return $this->container->view->render($response, 'home.tpl');
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
        $user = $request->getAttribute('user');
        $this->container->view['notificacoes'] =  $this->container->usuarioDAO->getConvitesPendentes($user->getId());

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
