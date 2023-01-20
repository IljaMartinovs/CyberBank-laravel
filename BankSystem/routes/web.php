<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BalanceTransferController;
use App\Http\Controllers\CodeCardController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\CryptoTransactionController;
use App\Http\Controllers\CryptoWalletController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserTransactionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index']);



Route::get('/crypto', [CryptoController::class, 'index'])->name('crypto.index');
Route::post('/crypto/{symbol}/buy', [CryptoController::class, 'buyCrypto'])->middleware(['auth'])->name('crypto.buy');
Route::post('/crypto/{symbol}/sell', [CryptoController::class, 'sellCrypto'])->middleware(['auth'])->name('crypto.sell');

Route::get('/transactions/{account}', [UserTransactionController::class, 'index'])->middleware(['auth'])->name('transaction.index');
Route::post('/transactions/{account}', [UserTransactionController::class, 'filterTransactions'])->middleware(['auth'])->name('transaction.filter');

Route::get('/crypto-transactions/{account}', [CryptoTransactionController::class, 'index'])->middleware(['auth'])->name('crypto-transaction.index');
Route::post('/crypto-transactions/{account}', [CryptoTransactionController::class, 'filterCryptoTransactions'])->middleware(['auth'])->name('crypto-transaction.filter');


Route::get('/crypto-wallet', [CryptoWalletController::class, 'index'])->middleware(['auth'])->name('crypto.wallet');

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

