<?php

declare(strict_types=1);

namespace ASPTest\Mappers;

use ASPTest\Entity\UserEntity;

class UserMapper
{
    public function map(array $data): UserEntity
    {
        return new UserEntity(
            (int) $data['id'] ?? null,
            $data['firstName'],
            $data['lastName'],
            $data['email'],
            (int) $data['age'] ?? null
        );
    }
}