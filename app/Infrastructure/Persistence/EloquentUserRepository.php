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
            'password' => encrypt($user->getPassword()) // Encriptación bidireccional
        ]);

        return new User($newUser->id, $newUser->name, $newUser->email, $newUser->password);
    }

    public function getById(int $id): ?User
    {
        $eloquentUser = EloquentUser::find($id);
        return $eloquentUser ? new User($eloquentUser->id, $eloquentUser->name, $eloquentUser->email, decrypt($eloquentUser->password)) : null;
    }

    public function getAll(): array
    {
        return EloquentUser::all()->map(function ($user) {
            try {
                $password = decrypt($user->password);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                $password = $user->password; // Si no se puede desencriptar, devolvemos el hash
            }
            
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ];
        })->toArray();
    }

    public function update(User $user): User
    {
        $eloquentUser = EloquentUser::findOrFail($user->getId());
        $eloquentUser->update([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => encrypt($user->getPassword()),
        ]);
        return new User($eloquentUser->id, $eloquentUser->name, $eloquentUser->email, $eloquentUser->password);
    }

    public function delete(int $id): bool
    {
        return EloquentUser::destroy($id) > 0;
    }
}
