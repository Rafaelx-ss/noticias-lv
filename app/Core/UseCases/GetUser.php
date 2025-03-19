<?php

namespace App\Core\UseCases;

use App\Core\Repositories\UserRepositoryInterface;
use App\Core\Entities\User;

class GetUser
{
    // Inyección de dependencias
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(int $id): ?User
    {
        return $this->UserRepositoryInterface->getById($id);
    }
}
