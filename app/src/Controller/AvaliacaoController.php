<?php
namespace App\Controller;
require __DIR__ . '/../../../vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;

class AvaliacaoController
{
    private $container;
    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'avaliacoes.tpl');
    }

    public function page1(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'avaliacaoPage1.tpl');
    }

    public function page2(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'avaliacaoPage2.tpl');
    }

    public function page3(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'avaliacaoPage3.tpl');
    }
}