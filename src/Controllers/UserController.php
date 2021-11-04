<?php

declare(strict_types=1);

namespace ASPTest\Controllers;

use ASPTest\Helpers\Bcrypt;
use ASPTest\Mappers\UserMapper;
use ASPTest\Entity\UserEntity;
use ASPTest\Services\UserServiceInterface;

class UserController 
{
    public function __construct(
        private UserServiceInterface $userService
    ) {
    }

    public function createUser(array $data)
    {
        if (!isset($data['firstName']) || strlen($data['firstName']) < 2 || strlen($data['firstName']) > 35) {
            throw new \RuntimeException('The firstName must contain more than 2 characters and less than 35.');
        }  

        if (!isset($data['lastName']) || strlen($data['lastName']) < 2 || strlen($data['lastName']) > 35) {
            throw new \RuntimeException('The lastName must contain more than 2 characters and less than 35.');
        }

        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('Email invalid format.');
        }

        if (isset($data['age']) && $data['age'] < 0 || $data['age'] > 150) {
            throw new \RuntimeException('Invalid age.');
        }

        $userMapper = new UserMapper();

        $userEntity = $userMapper->map($data);

        $userEntity = $this->userService->create($userEntity);

        return $userEntity;
    }

    public function updateUserPassword(array $data)
    {
        if (!isset($data['id'])) {
            throw new \RuntimeException('Id required.');
        }

        $uppercase = preg_match('@[A-Z]@', $data['password']);
        $lowercase = preg_match('@[a-z]@', $data['password']);
        $number = preg_match('@[0-9]@', $data['password']);
        $specialChars = preg_match('@[^\w]@', $data['password']);

        if (!isset($data['password']) || !$uppercase || !$lowercase || !$number || !$specialChars || strlen($data['password']) < 6) {
            throw new \RuntimeException(
                'The password must contain at least 6 characters, with at least one uppercase letter, one number, and one special character.'
            );
        }

        if (!isset($data['confirmPassword']) || $data['confirmPassword'] !== $data['password']) {
            throw new \RuntimeException('Passwords must match');
        }

        $userEntity = new UserEntity(null, '', '', '', null);

        $userEntity->setId(intval($data['id']));

        $userEntity = $this->userService->getUserById($userEntity->getId());

        $password = Bcrypt::hash($data['password'], 10);

        $userEntity->setPassword($password);

        $userEntity = $this->userService->updatePassword($userEntity);

        return $userEntity;
    }
}