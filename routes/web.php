<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailTypeController;
use App\Http\Controllers\IncomingMailController;
use App\Http\Controllers\OutgoingMailController;
use App\Http\Controllers\MailClassificationController;


Auth::routes();

Route::middleware(['auth'])->group(function () {
   
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    
    Route::prefix('/surat-masuk')->name('incomingmail.')->group(function () {
        Route::get('/data', [IncomingMailController::class, 'getData'])->name('data');
        Route::get('/', [IncomingMailController::class, 'index'])->name('index');
        Route::get('/create', [IncomingMailController::class, 'create'])->name('create');
        Route::post('/', [IncomingMailController::class, 'store'])->name('store');
        Route::get('/{id}', [IncomingMailController::class, 'detail'])->name('detail'); 
        Route::get('/{id}/edit', [IncomingMailController::class, 'edit'])->name('edit');
        Route::put('/{id}', [IncomingMailController::class, 'update'])->name('update'); // Pakai POST jika form HTML tidak support method PUT/PATCH
        Route::delete('/{id}', [IncomingMailController::class, 'destroy'])->name('destroy');
    });
   
    Route::prefix('surat-keluar')->name('outgoingmail.')->group(function () {
        Route::get('/data', [OutgoingMailController::class, 'getData'])->name('data');
        Route::get('/', [OutgoingMailController::class, 'index'])->name('index');
        Route::get('/create', [OutgoingMailController::class, 'create'])->name('create');
        Route::post('/', [OutgoingMailController::class, 'store'])->name('store');
        Route::get('/{id}', [OutgoingMailController::class, 'detail'])->name('detail'); 
        Route::get('/{id}/edit', [OutgoingMailController::class, 'edit'])->name('edit');
        Route::put('/{id}', [OutgoingMailController::class, 'update'])->name('update');
        Route::delete('/{id}', [OutgoingMailController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jenis-surat')->name('mailclassification.')->group(function () {
        Route::get('/data', [MailClassificationController::class, 'getData'])->name('data');
        Route::get('/', [MailClassificationController::class, 'index'])->name('index');
        Route::get('/create', [MailClassificationController::class, 'create'])->name('create');
        Route::post('/', [MailClassificationController::class, 'store'])->name('store');
        Route::get('/{id}', [MailClassificationController::class, 'detail'])->name('detail'); 
        Route::get('/{id}/edit', [MailClassificationController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MailClassificationController::class, 'update'])->name('update');
        Route::delete('/{id}', [MailClassificationController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('tipe-surat')->name('mailtype.')->group(function () {
        Route::get('/', [MailTypeController::class, 'index'])->name('index');
        Route::get('/data', [MailTypeController::class, 'getData'])->name('data');
        Route::get('/create', [MailTypeController::class, 'create'])->name('create');
        Route::post('/', [MailTypeController::class, 'store'])->name('store');
        Route::get('/{id}', [MailTypeController::class, 'detail'])->name('detail'); 
        Route::get('/{id}/edit', [MailTypeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MailTypeController::class, 'update'])->name('update');
        Route::delete('/{id}', [MailTypeController::class, 'destroy'])->name('destroy');
    });
});
