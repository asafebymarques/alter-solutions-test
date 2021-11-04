<?php

namespace Tests\Entity;

use ASPTest\Entity\UserEntity;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{

    public function UserProvider(): array
    {
        return [
            [1, 'John', 'Tester', 'Johntester@test.com', 49, null],
            [null, 'John', 'Tester', 'Johntester@test.com', 49, null],
        ];
    }

    /**
     * @dataProvider UserProvider
     */
    public function testGetUserInfo(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password) : void
    {
        $user = new UserEntity($id, $firstName, $lastName, $email, $age, $password);
        $this->assertEquals($id, $user->getId());
        $this->assertEquals($firstName.' '.$lastName, $user->getFullName());
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($age, $user->getAge());
    }

    /**
     * @dataProvider UserProvider
     */
    public function testGetUser(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password) : void 
    {
        $user = new UserEntity($id, $firstName, $lastName, $email, $age, $password);
        $this->assertIsArray($user->getUser(), "GetUser");
    }

    /**
     * @dataProvider UserProvider
     */
    public function testSetPassword(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password): void 
    {
        $user = new UserEntity($id, $firstName, $lastName, $email, $age, $password);
        $user->setPassword('123');

        $this->assertEquals('123', $user->getPassword());
    }
}