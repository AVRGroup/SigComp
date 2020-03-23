<?php

$app->map(['GET', 'POST'], '/login', '\App\Controller\LoginController:loginAction')->setName('login');
$app->get('/area-exclusiva', '\App\Controller\LoginController:areaExclusiva')->setName('area-exclusiva');
$app->post('/login-area-exclusiva', '\App\Controller\LoginController:loginAreaExclusiva')->setName('login-exclusivo');

$app->get('/about', '\App\Controller\HomeController:aboutAction')->setName('about');
$app->get('/phpInfo', '\App\Controller\HomeController:phpInfoAction')->setName('phpInfo');
$app->map(['GET', 'POST' ],'/send-mail', '\App\Controller\CertificateController:sendMailAction')->setName('sendMail');

$app->get('/avaliacoes', '\App\Controller\AvaliacaoController:index')->setName('avaliacoes');

$app->get('/questionarios', '\App\Controller\QuestionarioController:index')->setName('questionarios');

$app->get('/testeBuscaCEP','\App\Controller\UserController:indexBusca')->setName('buscaCEP');
$app->post('/pageBuscaCEP','\App\Controller\UserController:buscaCEP')->setName('pageBuscaCEP');

$app->group('', function () {
    $this->map(['GET', 'POST'],'/[#friends]', '\App\Controller\HomeController:indexAction')->setName('home');
    
    $this->get('/privacidade', '\App\Controller\HomeController:privacidadeAction')->setName('privacidade');
    $this->get('/list-profiles', '\App\Controller\LoginController:listProfilesAction')->setName('listProfiles');
    $this->get('/logout', '\App\Controller\LoginController:logoutAction')->setName('logout');
    
    $this->get('/avaliacaoPage01', '\App\Controller\AvaliacaoController:page1')->setName('avaliacaoPage01');
    $this->get('/avaliacaoPage02', '\App\Controller\AvaliacaoController:page2')->setName('avaliacaoPage02');
    $this->get('/avaliacaoPage03', '\App\Controller\AvaliacaoController:page3')->setName('avaliacaoPage03');

    $this->map(['GET', 'POST'], '/store-avaliacao-1', '\App\Controller\AvaliacaoController:storePage1')->setName('store-avaliacao-1');
    $this->map(['GET', 'POST'], '/store-avaliacao-2', '\App\Controller\AvaliacaoController:storePage2')->setName('store-avaliacao-2');
    $this->map(['GET', 'POST'], '/store-avaliacao-3', '\App\Controller\AvaliacaoController:storePage3')->setName('store-avaliacao-3');

    $this->post('Enviar', '\App\Controller\AvaliacaoController:Enviar')->setName('Enviar');

    $this->get('/edicaoQuestionario', '\App\Controller\QuestionarioController:edicaoQuestionario')->setName('edicaoQuestionario');
    $this->get('/edicaoQuestoes', '\App\Controller\QuestionarioController:edicaoQuestoes')->setName('edicaoQuestoes');
    $this->get('/excluiQuestao', '\App\Controller\QuestionarioController:excluiQuestao')->setName('excluiQuestao');

    $this->map(['GET', 'POST'], '/edicao-questoes', '\App\Controller\QuestionarioController:listaQuestoes')->setName('edicao-questoes');
    $this->map(['GET', 'POST'], '/store-questoes', '\App\Controller\QuestionarioController:storeQuestoes')->setName('store-questoes');

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
    $this->get('/oportunidade/{id: [0-9]+}', '\App\Controller\OportunidadeController:mostrarOportunidade');
    $this->get('/sair-impersonar', '\App\Controller\AdminController:sairImpersonar')->setName('sairImpersonar');

    $this->group('/admin', function () {

        $this->map(['GET', 'POST'],'/admin-dashboard', '\App\Controller\AdminController:adminDashboardAction')->setName('adminDashboard');

        $this->post('/set-concluido', '\App\Controller\AdminController:setConcluido')->setName('setConcluido');
        $this->post('/unset-concluido', '\App\Controller\AdminController:unsetConcluido')->setName('unsetConcluido');

        $this->get('/admin-email', '\App\Controller\AdminController:adminSendMail');
        $this->get('/teste-calcula-ira', '\App\Controller\AdminController:testeCalulaIra');


        $this->get('/impersonar-usuario/{id:[0-9]+}', '\App\Controller\AdminController:impersonarUsuario');

        $this->get('/grade', '\App\Controller\UserController:periodMedalsVerification')->setName('checkPeriodos');

        $this->get('/medals', '\App\Controller\UserController:assignMedalsAction')->setName('assignMedals');

        $this->map(['GET', 'POST'], '/editarCoordenadores', '\App\Controller\UserController:editarCoordenadores')->setName('editCoordenacao');

        $this->map(['GET', 'POST'], '/storeEditCoord', '\App\Controller\UserController:storeEditCoord')->setName('editCoord');

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

        $this->get('/cadastrar-oportunidade', '\App\Controller\OportunidadeController:formCadastrarOportunidade')->setName('cadastrarOportunidade');
        $this->post('/criar-oportunidade', '\App\Controller\OportunidadeController:criarOportunidade')->setName('ciarOportunidade');
        $this->get('/oportunidade/{id:[0-9]+}/delete', '\App\Controller\OportunidadeController:deleteOportunidade')->setName('deleteOportunidade');
        $this->get('/oportunidade/{id:[0-9]+}/form-edit', '\App\Controller\OportunidadeController:formEditOportunidade')->setName('formEditOportunidade');
        $this->post('/oportunidade/{id:[0-9]+}/edit', '\App\Controller\OportunidadeController:editOportunidade')->setName('editOportunidade');

        $this->map(['GET', 'POST'],'/certificate/{id:[0-9]+}/accept', '\App\Controller\CertificateController:adminAcceptAction')->setName('adminAcceptCertificate');
        $this->map(['GET', 'POST'],'/certificate/{id:[0-9]+}/refuse', '\App\Controller\CertificateController:adminRefuseAction')->setName('adminRefuseCertificate');
        $this->map(['GET', 'POST'],'/certificates', '\App\Controller\CertificateController:adminListReviewAction')->setName('adminListReviewCertificates');
    })->add('\App\Middleware\BolsistaMiddleware');

})->add('\App\Middleware\AuthMiddleware');

