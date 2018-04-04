<?php
// DIC configuration
$container = $app->getContainer();

//Smarty
$container['view'] = function ($container) {
    $settings = $container->get('settings');
    $view = new \Slim\Views\Smarty($settings['view']['template_path'], $settings['view']['smarty']);

    // Add Slim specific plugins
    $smartyPlugins = new \Slim\Views\SmartyPlugins($container['router'], $container['request']->getUri());
    $view->registerPlugin('function', 'path_for', [$smartyPlugins, 'pathFor']);
    $view->registerPlugin('function', 'base_url', [$smartyPlugins, 'baseUrl']);

    // Logged User set null
    $view['loggedUser'] = null;

    return $view;
};


//Not Found
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container->get('view')->render($response, '404.tpl')->withStatus(404);
    };
};

//Doctrine
$container['db'] = function ($container) {
    $settings = $container->get('settings');

    $config = new \Doctrine\ORM\Configuration();
    $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
    $driverImpl = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(new \Doctrine\Common\Annotations\AnnotationReader(),
        $settings['doctrine']['model']);
    \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
    $config->setMetadataDriverImpl($driverImpl);
    $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
    $config->setProxyDir($settings['doctrine']['cache_proxy']);
    $config->setProxyNamespace('App\Cache\Proxies');

    $config->setAutoGenerateProxyClasses(true);

    return \Doctrine\ORM\EntityManager::create($settings['db'], $config);
};

//Doctrine DAOs
$container['DisciplinaDAO'] = function ($container) {
    return new \App\Persistence\DisciplinaDAO($container['db']);
};

$container['UsuarioDAO'] = function ($container) {
    return new \App\Persistence\UsuarioDAO($container['db']);
};

$container['NotaDAO'] = function ($container) {
    return new \App\Persistence\NotaDAO($container['db']);
};

