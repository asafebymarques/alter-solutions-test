<?php

declare(strict_types=1);

namespace ASPTest\Entity;

class UserEntity
{
    private ?int $id;

    private string $firstName;

    private string $lastName;

    private string $email;

    private ?int $age;

    private string $password;

    public function __construct(?int $id, string $firstName, string $lastName, string $email, ?int $age)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->age = $age;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return $this->firstName.' '.$this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUser()
    {
        return [
            'id' => $this->id,
            'fullName' => $this->getFullName(),
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'age' => $this->age
        ];
    }
}