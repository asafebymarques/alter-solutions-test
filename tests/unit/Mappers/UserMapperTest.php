<?php

namespace Tests\Mappers;

use ASPTest\Entity\UserEntity;
use ASPTest\Mappers\UserMapper;
use PHPUnit\Framework\TestCase;

class UserMapperTest extends TestCase
{
    private $userMapper;

    public function setUp(): void
    {
        $this->userMapper = new UserMapper();
    }

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
    public function testMapperUser(?int $id, string $firstName, string $lastName, string $email, int $age, ?string $password) : void
    {
        $userEntity = $this->userMapper->map([
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age
        ]);
        $this->assertInstanceOf(UserEntity::class, $userEntity);
    }
}