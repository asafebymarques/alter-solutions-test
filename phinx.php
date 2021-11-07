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
            'adapter' => 'mysql',
            'host' => getenv('MYSQL_HOST'),
            'name' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USER'),
            'pass' => getenv('MYSQL_PASSWORD'),
            'port' => getenv('MYSQL_PORT'),
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => getenv('MYSQL_HOST'),
            'name' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USER'),
            'pass' => getenv('MYSQL_PASSWORD'),
            'port' => getenv('MYSQL_PORT'),
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => getenv('MYSQL_HOST'),
            'name' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USER'),
            'pass' => getenv('MYSQL_PASSWORD'),
            'port' => getenv('MYSQL_PORT'),
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];

