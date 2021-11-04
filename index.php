<?php

require __DIR__ . '/vendor/autoload.php';

use ASPTest\Command\CreateUserCommand;
use ASPTest\Command\CreateUserPWDCommand;
use Symfony\Component\Console\Application;

/** @var  \Psr\Container\ContainerInterface $container */
$container = require_once __DIR__ . "/config/container.php";

if(file_exists(__DIR__ . '/.env')){
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();    
}

$application = new Application();

$application->add(new CreateUserCommand(
    $container->get(\ASPTest\Controllers\UserController::class),
));

$application->add(new CreateUserPWDCommand(
    $container->get(\ASPTest\Controllers\UserController::class),
));

$application->run();