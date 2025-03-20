<?php

namespace App\Core\UseCases;

use App\Core\Repositories\UserRepositoryInterface;        

class DeleteUser
{

    // Inyección de dependencias
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(int $id): bool
    {
        return $this->userRepository->delete($id);

    }
}
