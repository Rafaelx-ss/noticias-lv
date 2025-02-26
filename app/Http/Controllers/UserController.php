<?php

namespace App\Http\Controllers;

use App\Core\UseCases\CreateUser;
use App\Core\UseCases\GetUser;
use App\Core\UseCases\ListUsers;
use App\Core\UseCases\UpdateUser;
use App\Core\UseCases\DeleteUser;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Controller;

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

    /**
     * Registra un nuevo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|min:2|max:100',
                'email' => 'required|email|max:150|unique:users,email',
                'password' => 'required|string|min:6|max:100',
            ]);
            $user = User::create($validatedData);
            return ResponseHelper::success(
                'Usuario registrado exitosamente', $user->makeHidden(['password']), 201
            );
        } catch (ValidationException $e) {
            return ResponseHelper::error('Datos de registro inválidos', $e->errors(), 400);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al crear la cuenta', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            // Validar las credenciales
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            error_log('Intento de inicio de sesión con email: ' . $credentials['email']);
            // Intentar autenticar al usuario
            if (!$token = Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                return ResponseHelper::error('Credenciales inválidas', [], 401);
            }
            // Obtener el usuario autenticado
            $user = Auth::user();
            error_log('Usuario autenticado: ' . $user->email);
            // Guardar el token en el usuario si es una instancia de Usuario
            if ($user instanceof User) {
                $user->remember_token = $token;
                $user->save();
                error_log('Token guardado para el usuario: ' . $user->email);
            }
            //Helper retorna lo mismo en el mismo formato que lo de arriba
            return ResponseHelper::success('Inicio de sesión exitoso', [
                'user' => $user,
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
                ]
            );
        } catch (ValidationException $e) {
            return ResponseHelper::error('Datos de inicio de sesión inválidos', ['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al iniciar sesión', ['error' => $e->getMessage()], 500);
        }
    }

}
