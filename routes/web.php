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
    Route::post('/login', [LoginController::class, 'storelogin']);
});

Route::middleware(['preventBackHistory','auth'])->group(function () {
    Route::get('/home', function() {        
            return redirect('/dashboard');        
    });
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['preventBackHistory','auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('main.dashboard');
    Route::get('/ubahpassword', [AdminController::class, 'ubahpw'])->name('main.ubahpassword');
    Route::get('/tambahpegawai', [AdminController::class, 'tambahpegawai'])->name('main.tambahpegawai');
    Route::get('/editpegawai/{datapegawai}', [AdminController::class, 'editpegawai'])->name('main.editpegawai');
    Route::get('/arsip/{datapegawai}', [AdminController::class, 'pesanarsip'])->name('main.arsip');
    

    Route::post('/dashboard/template', [WhatsappController::class, 'simpantemplate'])->name('main.simpanTemplate');
    Route::post('/dashboard/send', [WhatsappController::class, 'whatsapp'])->name('main.whatsapp');
    Route::put('/ubahpassword/update', [AdminController::class, 'updatePassword'])->name('main.updatepassword');
    Route::post('/tambahpegawai', [AdminController::class, 'storepegawai']);
    Route::put('/updatepegawai/{datapegawai}', [AdminController::class, 'updatepegawai'])->name('main.updatepegawai');
    Route::get('/hapuspegawai/{datapegawai:id}',[AdminController::class, 'deletepegawai'])->name('main.delete');
    Route::get('/hapustemplate/{template:id}',[WhatsappController::class, 'deletetemplate'])->name('main.templatedelete');
});