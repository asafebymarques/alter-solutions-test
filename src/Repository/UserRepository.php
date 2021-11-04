<?php

declare(strict_types=1);

namespace ASPTest\Repository;

use ASPTest\Entity\UserEntity;
use ASPTest\Mappers\UserMapper;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(
        private \PDO $connection,
        private UserMapper $userMapper
    ) {
    }

    public function create(UserEntity $user): UserEntity
    {
        try {
            $sql = "INSERT INTO `users` (`firstName`, `lastName`, `email`, `age`) VALUES (:firstName, :lastName, :email, :age)";

            $sql = $this->connection->prepare($sql);
            $sql->bindValue(':firstName', $user->getFirstName());
            $sql->bindValue(':lastName', $user->getLastName());
            $sql->bindValue(':email', $user->getEmail());
            $sql->bindValue(':age', $user->getAge());
            $sql->execute();

            if (!$this->connection->lastInsertId()) {
                throw new \Exception('Error to save user in database');
            }

            $userId = intval($this->connection->lastInsertId());

            $result = $this->findById($userId);
    
            return $result;

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function findById(int $id): UserEntity
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $sql = $this->connection->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if(!$sql->rowCount() > 0) {
            throw new \InvalidArgumentException("User not found!");
        }
        
        $result = $sql->fetch(\PDO::FETCH_ASSOC);

        return $this->userMapper->map($result);
    }

    public function update(UserEntity $user): UserEntity
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $sql = $this->connection->prepare($sql);
        $sql->bindValue(':password', $user->getPassword());
        $sql->bindValue(':id', $user->getId());
        $sql->execute();

        $result = $this->findById($user->getId());
    
        return $result;
    }
}