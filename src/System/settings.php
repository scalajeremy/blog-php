<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Twig templates settings
        'view' => [
            'path' => '../templates',
            'description' => 'My website',
            'baseUrl' => '/../',
            'twig' => [
              'cache' => false
            ],
        ],

        // Database connection settings
        'db' => [
            'host' => 'locahost',
            'port' => '5000',
            'dbname' => 'test',
            'user' => 'root',
            'pass' => 'root'
        ],
    ],
];
