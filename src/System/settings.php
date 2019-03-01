<?php

return [
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => true,
    'addContentLengthHeader' => false,
    'twig' => [
      'views' => dirname(__DIR__).'/View/',
      'cache' => false,
      'debug' => true
    ],

    'db' => [
        'driver' => 'pqsql',
        'host' => 'localhost',
        'port' => '5000',
        'database' => 'test',
        'username' => 'root',
        'password' => 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ]
];