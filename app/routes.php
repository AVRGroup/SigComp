<?php

$app->map(['GET', 'POST'], '/login', '\App\Controller\LoginController:loginAction')->setName('login');

$app->get('/about', '\App\Controller\HomeController:aboutAction')->setName('about');
$app->get('/phpInfo', '\App\Controller\HomeController:phpInfoAction')->setName('phpInfo');
$app->map(['GET', 'POST' ],'/send-mail', '\App\Controller\CertificateController:sendMailAction')->setName('sendMail');

$app->group('', function () {
    $this->map(['GET', 'POST'],'/[#friends]', '\App\Controller\HomeController:indexAction')->setName('home');

    $this->get('/privacidade', '\App\Controller\HomeController:privacidadeAction')->setName('privacidade');
    $this->get('/list-profiles', '\App\Controller\LoginController:listProfilesAction')->setName('listProfiles');
    $this->get('/logout', '\App\Controller\LoginController:logoutAction')->setName('logout');

    $this->map(['GET', 'POST'], '/list-certificates', '\App\Controller\CertificateController:listAction')->setName('listCertificates');
    $this->get('/certificate/{id:[0-9]+}/delete', '\App\Controller\CertificateController:deleteAction')->setName('deleteCertificate');

    $this->map(['GET', 'POST'], '/informacoes', '\App\Controller\UserController:informacoesPessoaisAction')->setName('informacoesPessoais');

    $this->get('/convite-amizade/{id-remetente: [0-9]+}&{id-destinatario: [0-9]+}', '\App\Controller\UserController:conviteAmizadeAction')->setName('conviteAmizade');
    $this->get('/aceitar-amizade/{id-remetente: [0-9]+}&{id-destinatario: [0-9]+}', '\App\Controller\UserController:aceitarConviteAction')->setName('aceitarAmizade');
    $this->get('/recusar-amizade/{id-remetente: [0-9]+}&{id-destinatario: [0-9]+}', '\App\Controller\UserController:rejeitarConviteAction')->setName('recusarAmizade');
    $this->map(['GET', 'POST'], '/lista-amigos/{id: [0-9]+}', '\App\Controller\UserController:listarAmigosAction')->setName('listaAmigos');

    $this->get('/forum', '\App\Controller\ForumController:showForumAction')->setName('forum');
    $this->map(['GET', 'POST'], '/forum/novoTopico/{id:[0-9]+}', '\App\Controller\ForumController:novoTopicoAction')->setName('novoTopico');
    $this->get('/forum/categorias/{id:[0-9]+}', '\App\Controller\ForumController:showCategoryAction')->setName('showCategory');
    $this->map(['GET', 'POST'],'/forum/topico/{id:[0-9]+}', '\App\Controller\ForumController:showTopicoAction')->setName('visualizarTopico');
    $this->map(['GET', 'POST'], '/forum/categorias', '\App\Controller\ForumController:listCategoriesAction')->setName('listCategories');
    $this->post('/forum/topico/responder', '\App\Controller\ForumController:responderAction')->setName('responder');


    $this->get('/amigo/{id: [0-9]+}','\App\Controller\UserController:visualizarAmigoAction')->setName('visualizarAmigo');

    $this->get('/exportPDF/{id:[0-9]+}', '\App\Controller\AdminController:exportPDFAction')->setName('exportPDF');

    $this->get('/todas-oportunidades', '\App\Controller\OportunidadeController:verOportunidades')->setName('verOportunidades');
    $this->get('/sair-impersonar', '\App\Controller\AdminController:sairImpersonar')->setName('sairImpersonar');

    $this->group('/admin', function () {

        $this->map(['GET', 'POST'],'/admin-dashboard', '\App\Controller\AdminController:adminDashboardAction')->setName('adminDashboard');

        $this->post('/set-concluido', '\App\Controller\AdminController:setConcluido')->setName('setConcluido');
        $this->post('/unset-concluido', '\App\Controller\AdminController:unsetConcluido')->setName('unsetConcluido');

        $this->get('/admin-email', '\App\Controller\AdminController:adminSendMail');

        $this->get('/cadastrar-oportunidade', '\App\Controller\OportunidadeController:formCadastrarOportunidade')->setName('cadastrarOportunidade');
        $this->post('/criar-oportunidade', '\App\Controller\OportunidadeController:criarOportunidade')->setName('ciarOportunidade');

        $this->get('/impersonar-usuario/{id:[0-9]+}', '\App\Controller\AdminController:impersonarUsuario');

        $this->get('/grade', '\App\Controller\UserController:periodMedalsVerification')->setName('checkPeriodos');

        $this->get('/medals', '\App\Controller\UserController:assignMedalsAction')->setName('assignMedals');

        $this->get('/test', '\App\Controller\UserController:adminTestAction')->setName('adminTest');

        $this->map(['GET', 'POST'], '/list-users', '\App\Controller\UserController:adminListAction')->setName('adminListUsers');
        $this->map(['GET', 'POST'], '/teste', '\App\Controller\UserController:teste');
        $this->get('/user/{id:[0-9]+}', '\App\Controller\AdminController:adminUserAction')->setName('adminUser');

        $this->get('/certificate/{id:[0-9]+}/delete', '\App\Controller\CertificateController:adminDeleteAction')->setName('adminDeleteCertificate');

        $this->map(['GET', 'POST'], '/data-load', '\App\Controller\AdminController:dataLoadAction')->setName('adminDataLoad');

        $this->map(['GET', 'POST'], '/grade-load', '\App\Controller\AdminController:gradeLoadAction')->setName('gradeLoadAction');

        $this->get('/data', '\App\Controller\AdminController:adminData')->setName('adminData');

        $this->get('/lista-alunos-logaram', '\App\Controller\AdminController:listAlunosLogaramAction')->setName('alunosLogaram');

        $this->map(['GET', 'POST'], '/forum/novaCategoria', '\App\Controller\ForumController:novaCategoriaAction')->setName('novaCategoria');

        $this->map(['GET', 'POST'], '/relatorio/periodizado', '\App\Controller\AdminController:listPeriodizadosAction')->setName('relatorioPeriodizado');
    })->add('\App\Middleware\AdminMiddleware');

    $this->group('/admin', function () {

        $this->map(['GET', 'POST'],'/certificate/{id:[0-9]+}/accept', '\App\Controller\CertificateController:adminAcceptAction')->setName('adminAcceptCertificate');
        $this->map(['GET', 'POST'],'/certificate/{id:[0-9]+}/refuse', '\App\Controller\CertificateController:adminRefuseAction')->setName('adminRefuseCertificate');
        $this->map(['GET', 'POST'],'/certificates', '\App\Controller\CertificateController:adminListReviewAction')->setName('adminListReviewCertificates');
    })->add('\App\Middleware\BolsistaMiddleware');

})->add('\App\Middleware\AuthMiddleware');

