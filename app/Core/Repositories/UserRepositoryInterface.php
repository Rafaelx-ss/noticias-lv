<?php

namespace App\Core\Repositories;

use App\Core\Entities\User;

interface UserRepositoryInterface       
{
    public function store(User $user): User;
    public function getById(int $id): ?User;
    public function getAll(): array;
    public function update(User $user): User;
    public function delete(int $id): bool;
}
