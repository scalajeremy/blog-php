<?php

return [
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => true,
    'addContentLengthHeader' => false,
    'twig' => [
      'views' => dirname(__DIR__).'/src/view/',
      'cache' => false
    ],
    'database' => [
        'driver' => 'pgsql',
        'host' => 'localhost',
        'port' => '5432',
        'database' => 'bicky',
        'username' => 'bicky',
        'password' => 'bicky',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]
];
