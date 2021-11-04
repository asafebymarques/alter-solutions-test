<?php

declare(strict_types=1);

namespace ASPTest\Services;

use ASPTest\Entity\UserEntity;
use ASPTest\Repository\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function create(UserEntity $user): UserEntity
    {
        $user = $this->userRepository->create($user);

        return $user;
    }

    public function updatePassword(UserEntity $user): UserEntity
    {
        $user = $this->userRepository->update($user);

        return $user;
    }

    public function getUserById(int $id): UserEntity 
    {
        $user = $this->userRepository->findById($id);

        return $user;
    }
}