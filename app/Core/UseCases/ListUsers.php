<?php

namespace App\Core\UseCases;

use App\Core\Repositories\UserRepositoryInterface;

class ListUsers
{
    private $userRepository; // Nombre correcto

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository; // Asigna correctamente
    }

    public function execute()
    {
        return $this->userRepository->getAll();
    }
}
