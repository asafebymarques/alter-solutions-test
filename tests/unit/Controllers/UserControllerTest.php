<?php

namespace Tests\Controllers;

use ASPTest\Controllers\UserController;
use ASPTest\Entity\UserEntity;
use ASPTest\Helpers\EncryptHelper;
use ASPTest\Mappers\UserMapper;
use ASPTest\Services\UserService;
use ASPTest\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{

    private $pdo;

    private $userRepository;

    private $userMapper;

    private $userService;

    public function setUp(): void
    {
        $this->pdo = new \PDO("mysql:host=asp-db;dbname=alter_solutions_db", 'user_solutions', 'alter-solutions');

        $this->userMapper = new UserMapper();

        $this->userRepository = new UserRepository($this->pdo, $this->userMapper);

        $this->userService = new UserService($this->userRepository);
    }

    
    public function UserProvider(): array
    {
        return [
            [1, 'John', 'Tester', 'Johntester@test.com', 49, '123456aA!@']
        ];
    }

    /**
     * @dataProvider UserProvider
     */
    public function testCreateUser(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $data = array(
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age
        );

        $userController = new UserController($this->userService);

        $userEntity = $userController->createUser($data);

        $this->assertInstanceOf(UserEntity::class, $userEntity);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testUpdatePassword(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $data = array(
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age,
            'password' => $password,
            'confirmPassword' => $password
        );

        $userController = new UserController($this->userService);

        $userEntity = $userController->updateUserPassword($data);

        $this->assertInstanceOf(UserEntity::class, $userEntity);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testIncorrectID(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage('Id required.');

        $data = array(
            'id' => null,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age,
            'password' => $password
        );

        $userController = new UserController($this->userService);

        $userController->updateUserPassword($data);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testIncorrectConfirmPassword(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage('Passwords must match');

        $data = array(
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age,
            'password' => $password
        );

        $userController = new UserController($this->userService);

        $userController->updateUserPassword($data);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testIncorrectPassword(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage('The password must contain at least 6 characters, with at least one uppercase letter, one number, and one special character.');

        $data = array(
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age,
            'password' => '123'
        );

        $userController = new UserController($this->userService);

        $userController->updateUserPassword($data);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testIncorrectShortFirtName(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage('The firstName must contain more than 2 characters and less than 35.');

        $data = array(
            'id' => $id,
            'firstName' => '',
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age,
            'password' => $password,
            'confirmPassword' => $password
        );

        $userController = new UserController($this->userService);

        $userController->createUser($data);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testIncorrectShortLastName(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage('The lastName must contain more than 2 characters and less than 35.');

        $data = array(
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => '',
            'email' => $email,
            'age' => $age,
            'password' => $password,
            'confirmPassword' => $password
        );

        $userController = new UserController($this->userService);

        $userController->createUser($data);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testIncorrectEmail(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage('Email invalid format.');

        $data = array(
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => 'asafe',
            'age' => $age,
            'password' => $password,
            'confirmPassword' => $password
        );

        $userController = new UserController($this->userService);

        $userController->createUser($data);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testIncorrectInvalidAge(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage('Invalid age.');

        $data = array(
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => 160,
            'password' => $password,
            'confirmPassword' => $password
        );

        $userController = new UserController($this->userService);

        $userController->createUser($data);
    }
}