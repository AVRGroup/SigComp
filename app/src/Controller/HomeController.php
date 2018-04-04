<?php

namespace App\Controller;

use App\Library\Helper;
use App\Library\Integra\login;
use App\Library\Integra\WSLogin;
use App\Model\Disciplina;
use App\Model\Nota;
use App\Model\Usuario;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function indexAction(Request $request, Response $response, $args)
    {
        return $this->container->get('view')->render($response, 'home.tpl');
    }

    public function aboutAction(Request $request, Response $response, $args)
    {
        return $this->container->get('view')->render($response, 'about.tpl');
    }

    public function testAction(Request $request, Response $response, $args)
    {
        set_time_limit(60 * 60);
        $data = Helper::processCSV('/Users/matheus/Desktop/lidiane/dados_alunos_35A1510690190786.csv');

        foreach ($data['disciplinas'] as $disc) {
            $disciplina = new Disciplina();
            $disciplina->setCodigo($disc['codigo']);
            $disciplina->setCarga($disc['carga']);
            $this->container['DisciplinaDAO']->persist($disciplina);
        }
        $this->container['DisciplinaDAO']->flush();

        $disciplinas = Helper::convertToIdArray($this->container['DisciplinaDAO']->getAll());

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

                $this->container['NotaDAO']->persist($nota);
            }

            $this->container['UsuarioDAO']->save($usuario);
        }

        return $this->container->get('view')->render($response, 'home.tpl');
    }


}
