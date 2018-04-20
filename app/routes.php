<?php

$app->map(['GET', 'POST'], '/login', '\App\Controller\LoginController:loginAction')->setName('login');

$app->get('/test', '\App\Controller\HomeController:testAction')->setName('test');
$app->get('/about', '\App\Controller\HomeController:aboutAction')->setName('about');

$app->group('', function () {

    $this->get('/', '\App\Controller\HomeController:indexAction')->setName('home');
    $this->get('/list-profiles', '\App\Controller\LoginController:listProfilesAction')->setName('listProfiles');
    $this->get('/logout', '\App\Controller\LoginController:logoutAction')->setName('logout');

    $this->map(['GET', 'POST'], '/list-certificates', '\App\Controller\CertificateController:listAction')->setName('listCertificates');
    $this->get('/certificate/{id:[0-9]+}/delete', '\App\Controller\CertificateController:deleteAction')->setName('deleteCertificate');

    $this->group('/admin', function () {

        $this->get('/test', '\App\Controller\UserController:adminTestAction')->setName('adminTest');

        $this->get('/list-users', '\App\Controller\UserController:adminListAction')->setName('adminListUsers');
        $this->get('/user/{id:[0-9]+}', '\App\Controller\UserController:adminUserAction')->setName('adminUser');

        $this->get('/certificates', '\App\Controller\CertificateController:adminListReviewAction')->setName('adminListReviewCertificates');
        $this->get('/certificate/{id:[0-9]+}/delete', '\App\Controller\CertificateController:adminDeleteAction')->setName('adminDeleteCertificate');
        $this->get('/certificate/{id:[0-9]+}/change/{state}', '\App\Controller\CertificateController:adminChangeAction')->setName('adminChangeCertificate');

    })->add('\App\Middleware\AdminMiddleware');

})->add('\App\Middleware\AuthMiddleware');

