<?php

namespace App\Http\Controllers;

use App\Core\UseCases\CreateUser;
use App\Core\UseCases\GetUser;
use App\Core\UseCases\ListUsers;
use App\Core\UseCases\UpdateUser;
use App\Core\UseCases\DeleteUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private CreateUser $createUser,
        private GetUser $getUser,
        private ListUsers $listUsers,
        private UpdateUser $updateUser,
        private DeleteUser $deleteUser
    ) {}

    public function store(Request $request)
    {
        $user = $this->createUser->execute($request->all());
        return response()->json(['user' => $user], 201);
    }

    public function show(int $id)
    {
        $user = $this->getUser->execute($id);
        return $user ? response()->json($user) : response()->json(['error' => 'User not found'], 404);
    }

    public function index()
    {
        return response()->json($this->listUsers->execute());
    }

    public function update(Request $request, int $id)
    {
        $user = $this->updateUser->execute($id, $request->all());
        return response()->json(['user' => $user]);
    }

    public function destroy(int $id)
    {
        return $this->deleteUser->execute($id)
            ? response()->json(['message' => 'User deleted'])
            : response()->json(['error' => 'User not found'], 404);
    }
}
