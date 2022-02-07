<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PokemonController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('add-info', [RegisterController::class, 'addInformation']);
Route::post('login', [LoginController::class, 'login']);
Route::post('add-pokemon', [PokemonController::class, 'addUserPokemon']);

Route::get('user/list', [UserController::class, 'getAllUsers']);
Route::get('user/{user_id}', [UserController::class, 'getSpecificUser']);
Route::get('pokemon/list/{name?}',[PokemonController::class, 'pokemon']);
Route::get('pokemon/paged-list/{limit}',[PokemonController::class, 'pokemonWithPaging']);
Route::get('get-pokemon/{user_id}', [PokemonController::class, 'getUserPokemon']);

Route::put('user/update', [UserController::class, 'updateUser']);

Route::post('remove-pokemon', [PokemonController::class, 'deleteUserPokemon']);