<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PerkController;
use App\Http\Controllers\WorldController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Character routes
    Route::resource('characters', CharacterController::class);
    
    // Role routes
    Route::resource('roles', RoleController::class);
    
    // Perk routes
    Route::resource('perks', PerkController::class);
    
    // World routes
    Route::resource('worlds', WorldController::class);
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';