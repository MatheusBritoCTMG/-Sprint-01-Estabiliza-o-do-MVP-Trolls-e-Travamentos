<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');

/**
 * TICKET #005 (Proteção com Middleware):
 * Apenas usuários autenticados podem enviar perguntas. Visitantes anônimos
 * são redirecionados para a rota nomeada "login" (HTTP 302) pelo middleware 'auth'.
 */
Route::post('/eventos/{id}/perguntas', [EventoController::class, 'storePergunta'])
    ->middleware('auth')
    ->name('eventos.perguntas.store');

// Rotas de autenticação (login / registro / logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
