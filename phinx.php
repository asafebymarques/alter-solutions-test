<?php

require __DIR__ . '/vendor/autoload.php';

if(file_exists(__DIR__ . '/.env')){
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();    
}

return
[
    'paths' => [
        'migrations' => [
            __DIR__ . '/src/Database/Migrations'
        ],
        'seeds' => [
            __DIR__ . '/src/Database/Seeds'
        ]
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'development',
        'production' => [
            'adapter' => $_ENV['DB_CONNECTION'],
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => $_ENV['DB_CONNECTION'],
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => $_ENV['DB_CONNECTION'],
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];

