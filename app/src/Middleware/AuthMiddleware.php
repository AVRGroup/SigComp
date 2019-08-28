<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {
        if (!isset($_SESSION['id']) || ($user = $this->container->usuarioDAO->getById($_SESSION['id'])) == null) {
            return $response->withRedirect($this->container->router->pathFor('login'));
        }

        $this->container->view['loggedUser'] = $user;
        $this->container->view['estaImpersonando'] = isset($_SESSION['estaImpersonando']);

        $newRequest = $request->withAttribute('user', $user);

        return $next($newRequest, $response);
    }
}
