<?php

use App\Http\Controllers\HomeController;
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

require __DIR__.'/auth.php';
