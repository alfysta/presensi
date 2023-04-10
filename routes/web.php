<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Auth\{Login, Register};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['login' => false, 'register' => false]);

Route::middleware('guest')->group(function(){
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');

});

Route::middleware('auth')->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/create', [HomeController::class, 'create'])->name('home.create');
    Route::post('/home/store', [HomeController::class, 'store'])->name('home.store');

});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
