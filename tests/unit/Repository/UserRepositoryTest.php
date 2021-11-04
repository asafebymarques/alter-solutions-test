<?php

namespace Tests\Repository;

use ASPTest\Entity\UserEntity;
use ASPTest\Mappers\UserMapper;
use ASPTest\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{

    private $pdo;

    private $userMapper;

    public function setUp(): void
    {
        $this->pdo = new \PDO("mysql:host=localhost;dbname=alter_solutions_db", 'root', '');

        $this->userMapper = new UserMapper();
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
        $userEntity = $this->userMapper->map([
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age
        ]);

        $userRepository = new UserRepository($this->pdo, $this->userMapper);

        $userEntity = $userRepository->create($userEntity);

        $this->assertInstanceOf(UserEntity::class, $userEntity);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testFindnUserById(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $userEntity = $this->userMapper->map([
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age
        ]);

        $userRepository = new UserRepository($this->pdo, $this->userMapper);

        $userEntity = $userRepository->findById($userEntity->getId());

        $this->assertInstanceOf(UserEntity::class, $userEntity);
    }

    /**
     * @dataProvider UserProvider
     */
    public function testUpdatePassword(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $userEntity = $this->userMapper->map([
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age,
        ]);

        $userEntity->setPassword($password);

        $userRepository = new UserRepository($this->pdo, $this->userMapper);

        $userEntity = $userRepository->update($userEntity);

        $this->assertInstanceOf(UserEntity::class, $userEntity);
    }
}