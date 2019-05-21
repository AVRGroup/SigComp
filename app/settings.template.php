<?php
return [
    'settings' => [
        // Slim settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'smarty' => [
                'cacheDir' => __DIR__ . '/../cache/smarty/cache',
                'compileDir' => __DIR__ . '/../cache/smarty/compile',
            ],
        ],

        // Doctrine
        'doctrine' => [
            'model' => __DIR__ . '/src/Model',
            'cache_proxy' => __DIR__ . '/../cache/doctrine',
        ],

        // DB Conection
        'db' => [
            'driver' => 'pdo_mysql',
            'user' => 'USER',
            'password' => 'PASS',
            'dbname' => 'DBNAME',
            'host' => 'localhost:3306'
        ],

        //Integra
        'integra' => [
            'token' => 'TOKEN_HERE',
        ],

        //Upload Path
        'upload' => [
            'path' => __DIR__ . '/../public/upload',
            'allowedCertificationExtensions' => ['jpg', 'jpeg', 'png', 'pdf'],
            'allowedPictureExtensions' => ['jpg', 'jpeg', 'png'],
            'allowedDataLoadExtensions' => ['csv'],
            'maxBytesSize' => 2097152
        ]
    ],
];
