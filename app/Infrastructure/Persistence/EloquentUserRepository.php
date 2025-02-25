<?php

namespace App\Infrastructure\Persistence;

use App\Core\Repositories\UserRepositoryInterface;
use App\Models\User as EloquentUser;
use App\Core\Entities\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function store(User $user): User
    {
        $newUser = EloquentUser::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => bcrypt($user->getPassword()) // Hash de la contraseña
        ]);

        return new User($newUser->id, $newUser->name, $newUser->email, $newUser->password);
    }

    public function getById(int $id): ?User
    {
        $eloquentUser = EloquentUser::find($id);
        return $eloquentUser ? new User($eloquentUser->id, $eloquentUser->name, $eloquentUser->email, $eloquentUser->password) : null;
    }

    public function getAll(): array
{
    return EloquentUser::all()->map(function ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    })->toArray();
}


    public function update(User $user): User
    {
        $eloquentUser = EloquentUser::findOrFail($user->getId());
        $eloquentUser->update([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => bcrypt($user->getPassword()),
        ]);
        return new User($eloquentUser->id, $eloquentUser->name, $eloquentUser->email, $eloquentUser->password);
    }

    public function delete(int $id): bool
    {
        return EloquentUser::destroy($id) > 0;
    }
}
