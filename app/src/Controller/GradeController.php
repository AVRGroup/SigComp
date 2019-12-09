<?php


namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class GradeController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'verGrades.tpl');
    }


}