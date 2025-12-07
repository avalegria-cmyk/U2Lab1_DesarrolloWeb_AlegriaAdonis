<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Ruta principal - listado de publicaciones
Route::get('/', [PostController::class, 'index'])->name('home');

// Rutas que requieren autenticación
Route::middleware('auth')->group(function () {

    // Rutas de perfil (de Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard básico
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    // IMPORTANTE: La ruta /posts/create DEBE ir ANTES de /posts/{post}
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Gestión de usuarios: solo admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::post('/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
    });


});

// Vista detallada de una publicación (pública) - DEBE ir DESPUÉS de /posts/create
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Comentarios públicos (no requieren autenticación)
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

require __DIR__ . '/auth.php';