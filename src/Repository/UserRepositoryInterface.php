<?php

declare(strict_types=1);

namespace ASPTest\Repository;

use ASPTest\Entity\UserEntity;

interface UserRepositoryInterface
{
    public function create(UserEntity $user): UserEntity;

    public function findById(int $id): UserEntity;

    public function update(UserEntity $user): UserEntity;
}