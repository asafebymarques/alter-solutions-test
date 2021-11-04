<?php

use DI\ContainerBuilder;

use ASPTest\Entity\UserEntity;
use ASPTest\Controllers\UserController;
use ASPTest\Helpers\EncryptHelper;
use ASPTest\Mappers\UserMapper;
use ASPTest\Repository\UserRepository;
use ASPTest\Repository\UserRepositoryInterface;
use ASPTest\Services\UserServiceInterface;
use ASPTest\Services\UserService;

use Psr\Container\ContainerInterface;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    UserServiceInterface::class => \DI\create(UserService::class)->constructor(\DI\get(UserRepositoryInterface::class)),
    UserRepositoryInterface::class => \DI\create(UserRepository::class)->constructor(
        \DI\get(PDO::class),
        \DI\get(UserMapper::class)
    ),
    UserController::class => \DI\create(UserController::class)->constructor(
        \DI\get(UserServiceInterface::class)
    ),
    PDO::class => function (ContainerInterface $container) {
        $conn = new \PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']}", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        return $conn;
    },
]);

return $containerBuilder->build();