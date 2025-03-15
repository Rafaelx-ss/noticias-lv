<?php

namespace App\Core\UseCases;

use App\Core\Repositories\UserRepositoryInterface;
use App\Core\Entities\User;

class UpdateUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(int $id, array $data): User
    {

        
        $user = new User(
            id: $id,
            name: $data['name'],
            email: $data['email'],
            password: $data['password']
        );

        return $this->userRepository->update($user);

    }
}
