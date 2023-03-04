<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LifeLogController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard')
->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name('lifelog.')->middleware('auth')->prefix('lifelog')->group(function () {
    Route::get('manage', [LifeLogController::class, 'index'])->name('index');
    Route::get('create', [LifeLogController::class, 'index'])->name('create');
    Route::post('save', [LifeLogController::class, 'store'])->name('save');
    Route::get('edit/{id}', [LifeLogController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [LifeLogController::class, 'update'])->name('update');
});

Route::name('lifelogcategory.')->middleware('auth')->prefix('lifelogcategory')->group(function () {
    Route::get('manage', [LifeLogController::class, 'categoryIndex'])->name('index');
    Route::post('save', [LifeLogController::class, 'categoryStore'])->name('save');
    Route::get('edit/{id}', [LifeLogController::class, 'categoryEdit'])->name('edit');
    Route::post('update/{id}', [LifeLogController::class, 'categoryUpdate'])->name('update');
});

Route::name('role.')->middleware('auth')->prefix('role')->group(function () {
    Route::get('index', [RoleController::class, 'index'])->name('index');
    Route::get('edit/{id}', [RoleController::class, 'edit'])->name('edit');
    Route::post('edit/{id}/update', [RoleController::class, 'update'])->name('update');
});

Route::name('user.')->middleware('auth')->prefix('user')->group(function () {
    Route::get('index', [UserController::class, 'index'])->name('index');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::post('edit/{id}/update', [UserController::class, 'update'])->name('update');
});


require __DIR__.'/auth.php';
