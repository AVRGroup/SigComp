<?php


namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class ProfessorMiddleware
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {
        $user = $this->container->usuarioDAO->getById($_SESSION['id']);

        if (!isset($_SESSION['id']) || $user->isAluno() || $user->isBolsista()) {
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        $this->container->view['loggedUser'] = $user;
        $newRequest = $request->withAttribute('user', $user);


        return $next($newRequest, $response);
    }
}
