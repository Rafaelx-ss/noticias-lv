<?php

namespace App\Core\UseCases;

use App\Core\Repositories\UserRepositoryInterface;
use App\Core\Entities\User;

class CreateUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): User
    {
        $user = new User(null, $data['name'], $data['email'], $data['password']);

        // Asegúrate de llamar a store() y NO a save()
        return $this->userRepository->store($user);
    }
}
