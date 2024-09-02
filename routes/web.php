<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\SuperAdminController;
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
        if (Auth::user()->role == 'Super-Admin') {
            return redirect ('/dashboard');
        }elseif (Auth::user()->role == 'Admin') {
            return redirect ('/admindashboard');
        }       
    });
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});


//Super Admin
Route::middleware(['preventBackHistory','auth','userAccess:Super-Admin'])->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('Super-Admin.dashboard');
    Route::get('/datapegawai', [SuperAdminController::class, 'datapegawai'])->name('Super-Admin.datapegawai');
    Route::get('/ubahpassword', [SuperAdminController::class, 'ubahpw'])->name('Super-Admin.ubahpassword');
    Route::get('/daftarpegawai', [SuperAdminController::class, 'daftarpegawai'])->name('Super-Admin.daftarpegawai');
    Route::get('/tambahpegawai', [SuperAdminController::class, 'tambahpegawai'])->name('Super-Admin.tambahpegawai');
    Route::get('/editpegawai/{datapegawai}', [SuperAdminController::class, 'editpegawai'])->name('Super-Admin.editpegawai');
    Route::get('/arsip/{datapegawai}', [SuperAdminController::class, 'pesanArsip'])->name('Super-Admin.arsip');
    Route::get('/riwayatpesan', [SuperAdminController::class, 'riwayatpesan'])->name('Super-Admin.riwayatpesan');
    Route::get('/settings', [SuperAdminController::class, 'settings'])->name('Super-Admin.settings');
    Route::get('/editadmin/{user}', [SuperAdminController::class, 'editadmin'])->name('Super-Admin.editadmin');
    
    Route::get('/daftaradmin', [SuperAdminController::class, 'daftaradmin'])->name('Super-Admin.daftaradmin');
    Route::post('/tambahadmin', [SuperAdminController::class, 'storeadmin'])->name('Super-Admin.tambahadmin');
    Route::put('/updateadmin/{user}', [SuperAdminController::class, 'updateadmin'])->name('Super-Admin.updateadmin');
    Route::get('/hapusadmin/{dataadmin}',[SuperAdminController::class, 'deleteadmin'])->name('Super-Admin.deleteadmin');
    Route::get('/aktif/{user:id}',[SuperAdminController::class, 'aktif']);
    Route::get('/nonaktif/{user:id}',[SuperAdminController::class, 'nonaktif']);

    Route::post('/dashboard/template', [WhatsappController::class, 'simpantemplate'])->name('Super-Admin.simpanTemplate');
    Route::post('/dashboard/send', [WhatsappController::class, 'whatsapp'])->name('Super-Admin.whatsapp');
    Route::put('/ubahpassword/update', [SuperAdminController::class, 'updatePassword'])->name('Super-Admin.updatepassword');
    Route::post('/tambahpegawai', [SuperAdminController::class, 'storepegawai']);
    Route::put('/updatepegawai/{datapegawai}', [SuperAdminController::class, 'updatepegawai'])->name('Super-Admin.updatepegawai');
    Route::get('/hapuspegawai/{datapegawai}',[SuperAdminController::class, 'deletepegawai'])->name('Super-Admin.delete');
    Route::post('/settings', [SuperAdminController::class, 'settingsupdate']);
    Route::get('/hapustemplate/{template:id}',[WhatsappController::class, 'deletetemplate'])->name('Super-Admin.templatedelete');
});

//Admin
Route::middleware(['preventBackHistory','auth','userAccess:Admin'])->group(function () {
    Route::get('/admindashboard', [AdminController::class, 'index'])->name('Admin.admindashboard');
    Route::get('/pegawai', [AdminController::class, 'datapegawai'])->name('Admin.datapegawai');
    Route::get('/adminubahpassword', [AdminController::class, 'ubahpw'])->name('Admin.adminubahpassword');
    Route::get('/admindaftarpegawai', [AdminController::class, 'daftarpegawai'])->name('Admin.admindaftarpegawai');
    Route::get('/admintambahpegawai', [AdminController::class, 'tambahpegawai'])->name('Admin.admintambahpegawai');
    Route::get('/admineditpegawai/{datapegawai}', [AdminController::class, 'editpegawai'])->name('Admin.admineditpegawai');
    Route::get('/adminarsip/{datapegawai}', [AdminController::class, 'pesanArsip'])->name('Admin.adminarsip');
    Route::get('/adminriwayatpesan', [AdminController::class, 'riwayatpesan'])->name('Admin.adminriwayatpesan');
    
    Route::get('/dataadmin', [AdminController::class, 'daftaradmin'])->name('Admin.dataadmin');

    Route::post('/dadmindashboar/template', [WhatsappController::class, 'simpantemplate'])->name('Admin.simpanTemplate');
    Route::post('/admindashboard/send', [WhatsappController::class, 'whatsapp'])->name('Admin.whatsapp');
    Route::put('/adminubahpassword/update', [AdminController::class, 'updatePassword'])->name('Admin.updatepassword');
    Route::post('/admintambahpegawai', [AdminController::class, 'storepegawai']);
    Route::put('/adminupdatepegawai/{datapegawai}', [AdminController::class, 'updatepegawai'])->name('Admin.updatepegawai');
    Route::get('/adminhapuspegawai/{datapegawai}',[AdminController::class, 'deletepegawai'])->name('Admin.delete');
    Route::get('/adminhapustemplate/{template:id}',[WhatsappController::class, 'deletetemplate'])->name('Admin.templatedelete');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/download/{arsip_pesan}', [WhatsappController::class, 'download'])->name('file.download');
});