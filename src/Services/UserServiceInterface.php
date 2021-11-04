<?php

declare(strict_types=1);

namespace ASPTest\Services;

use ASPTest\Entity\UserEntity;

interface UserServiceInterface
{
    public function create(UserEntity $user): UserEntity;

    public function updatePassword(UserEntity $user): UserEntity;

    public function getUserById(int $id): UserEntity;
}
