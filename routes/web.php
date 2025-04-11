<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CommonStatusController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransparencyCodeController;
use App\Http\Controllers\TransparencyProductFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('account-config', AccountController::class)->except(['show']);
    Route::resource('product-file', TransparencyProductFileController::class)->only(['index', 'create', 'store']);
    Route::get('product-list', ProductListController::class)->name('product-list.index');

    Route::put('update-status', CommonStatusController::class)->name('update-status');

    Route::get('transparency-code', [TransparencyCodeController::class, 'index'])->name('transparency-code.index');
    Route::post('generate-transparency-code/{transparency_product_id}', [TransparencyCodeController::class, 'generateTransparencyCode'])->name('transparency-code.store');
    Route::post('download-code/{id}', [TransparencyCodeController::class, 'generateBarcode'])->name('transparency-code.download');
    Route::get('get-qr-code', [TransparencyCodeController::class, 'generateQRCodeHtml'])->name('transparency-code.get-qr-code');
});

require __DIR__.'/auth.php';
