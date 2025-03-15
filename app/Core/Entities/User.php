<?php

namespace App\Core\Entities;

class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(?int $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    // ✅ Métodos GET para acceder a los datos
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    // ✅ Métodos para actualizar la información del usuario
    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function updateEmail(string $email): void
    {
        $this->email = $email;
    }

    public function updatePassword(string $password): void
    {
        $this->password = $password;
    }
}

