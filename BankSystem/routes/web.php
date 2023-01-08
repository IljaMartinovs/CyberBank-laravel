<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BalanceTransferController;
use App\Http\Controllers\CodeCardController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index']);

Route::get('/crypto', [CryptoController::class, 'getCrypto']);
Route::get('/crypto/buy/{symbol}', [CryptoController::class, 'getCrypto'])->middleware(['auth'])->name('crypto.get');
Route::post('/crypto/buy/{symbol}', [CryptoController::class, 'buyCrypto'])->middleware(['auth'])->name('crypto.buy');

Route::get('/accounts',[AccountController::class, 'show'])->middleware(['auth'])->name('accounts.show');
Route::post('/accounts',[AccountController::class, 'create'])->middleware(['auth'])->name('accounts.create');
Route::get('/accounts/{account}/edit',[AccountController::class, 'edit'])->middleware(['auth'])->name('accounts.edit');
Route::put('/accounts/{account}',[AccountController::class, 'update'])->middleware(['auth'])->name('accounts.update');
Route::post('/accounts/{account}',[AccountController::class, 'delete'])->middleware(['auth'])->name('accounts.delete');

Route::get('/balance-transfer', [BalanceTransferController::class, 'show'])->middleware(['auth'])->name('balance-transfer.update');
Route::post('/balance-transfer', [BalanceTransferController::class, 'transfer'])->middleware(['auth'])->name('balance-transfer.transfer');

Route::get('/code-cards', [CodeCardController::class, 'index'])
    ->middleware(['auth'])
    ->name('code-cards.index');

