<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetLocaleController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Accueil de l'application
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Routes pour les tâches
Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
Route::get('/task/{task}', [TaskController::class, 'show'])->name('task.show');
Route::middleware('auth')->group(function () {
    Route::get('/create/task', [TaskController::class, 'create'])->name('task.create');
    Route::post('/create/task', [TaskController::class, 'store'])->name('task.store');
    Route::get('/edit/task/{task}', [TaskController::class, 'edit'])->name('task.edit');
    Route::put('/edit/task/{task}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task/{task}', [TaskController::class, 'destroy'])->name('task.delete');
    //Route pour le filtre des tâches complétées
    Route::get('/completed/task/{completed}', [TaskController::class, 'completed'])->name('task.completed');
    //Route pour les catégories
    Route::get('/create/category', [CategoryController::class, 'create'])->name('category.create')->middleware('can:create-category');
    Route::post('/create/category', [CategoryController::class, 'store'])->name('category.store');
    //Route pour la génération de PDF
    Route::get('/task-pdf/{task}', [TaskController::class, 'pdf'])->name('task.pdf');
});

//Routes pour les utilisateurs 
Route::get('/users', [UserController::class, 'index'])->name('user.index')->middleware('auth');
Route::get('/registration', [UserController::class, 'create'])->name('user.create');
Route::post('/registration', [UserController::class, 'store'])->name('user.store');

//Route pour le mot de passe oublié
Route::get('/password/forgot', [UserController::class, 'forgot'])->name('user.forgot');
Route::post('/password/forgot', [UserController::class, 'email'])->name('user.email');
Route::get('/password/reset/{user}/{token}}', [UserController::class, 'reset'])->name('user.reset');
Route::put('/password/reset/{user}/{token}}', [UserController::class, 'resetUpdate'])->name('user.reset.update');

//Route pour la connexion
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');

//Route pour la gestion des langues
Route::get('/lang/{locale}', [SetLocaleController::class, 'index'])->name('lang');