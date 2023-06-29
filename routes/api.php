<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']); // Obtener todos los usuarios
    Route::post('/', [UserController::class, 'store']); // Agregar un nuevo usuario
    Route::put('/{id}', [UserController::class, 'update']); // Actualizar un usuario existente
    Route::delete('/{id}', [UserController::class, 'destroy']); // Eliminar un usuario existente
});