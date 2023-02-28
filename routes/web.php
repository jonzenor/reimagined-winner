<?php

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name('lifelog.')->middleware('auth')->prefix('lifelog')->group(function () {
    Route::get('manage', [LifeLogController::class, 'index'])->name('index');
    Route::get('create', [LifeLogController::class, 'create'])->name('create');
    Route::post('save', [LifeLogController::class, 'store'])->name('save');
});

require __DIR__.'/auth.php';
