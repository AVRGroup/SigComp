<?php

$app->map(['GET', 'POST'], '/login', '\App\Controller\UserController:loginAction')->setName('login');

$app->get('/test', '\App\Controller\HomeController:testAction')->setName('test');
$app->get('/about', '\App\Controller\HomeController:aboutAction')->setName('about');

$app->group('', function () {

    $this->get('/', '\App\Controller\HomeController:indexAction')->setName('home');
    $this->get('/logout', '\App\Controller\UserController:logoutAction')->setName('logout');
    $this->get('/list-profiles', '\App\Controller\UserController:listProfilesAction')->setName('listProfiles');

})->add('\App\Middleware\AuthMiddleware');

