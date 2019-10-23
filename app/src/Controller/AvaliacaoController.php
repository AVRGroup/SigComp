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
}