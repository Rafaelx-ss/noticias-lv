<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories', [CategorieController::class, 'index']); 
Route::post('/categories', [CategorieController::class, 'store']);
Route::put('/categories/{id}', [CategorieController::class, 'update']); 
Route::delete('/categories/{id}', [CategorieController::class, 'destroy']);



Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);       // Obtener todos los usuarios
    Route::post('/', [UserController::class, 'store']);      // Crear un usuario
    Route::get('/{id}', [UserController::class, 'show']);    // Obtener un usuario por ID
    Route::put('/{id}', [UserController::class, 'update']);  // Actualizar usuario
    Route::delete('/{id}', [UserController::class, 'destroy']); // Eliminar usuario
});
