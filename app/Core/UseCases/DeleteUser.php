<?php

namespace App\Core\UseCases;

use App\Core\Repositories\UserRepositoryInterface;

class DeleteUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(int $id): bool
    {
        return $this->userRepository->delete($id);

    }
}
