<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

Route::middleware(['preventBackHistory','guest'])->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'storelogin'])->middleware('resetDaily');
});

Route::middleware(['preventBackHistory','auth'])->group(function () {
    Route::get('/home', function() {        
            return redirect('/dashboard');        
    });
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['preventBackHistory','auth','userAccess:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('main.dashboard');
    
    Route::post('/dashboard/gaji', [WhatsappController::class, 'whatsapp'])->name('send.whatsapp');
});