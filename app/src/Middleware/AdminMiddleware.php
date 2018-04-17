<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class AdminMiddleware
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {

        //TODO Check if it's admin user

        return $next($request, $response);
    }
}
