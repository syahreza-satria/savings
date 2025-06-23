<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DarkModeController;

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
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){
    Route::get('/', [AppController::class, 'index'])->name('app');
    Route::post('/toggle-dark-mode', [DarkModeController::class, 'toggle'])->name('dark-mode.toggle');
    Route::get('/chart-data', [AppController::class, 'getChartData'])->middleware('auth');

    // Bills
    Route::get('/bills', [AppController::class, 'bills'])->name('bills');
    Route::post('/bills/store', [AppController::class, 'bill_store'])->name('bills.store');
    Route::put('/bills/{bill}', [AppController::class, 'bill_update'])->name('bills.update');
    Route::patch('/bills/{bill}/paid', [AppController::class, 'bill_paid'])->name('bills.paid');
    Route::delete('/bills/{bill}', [AppController::class, 'bill_destroy'])->name('bills.destroy');

    // Savings
    Route::get('/savings', [AppController::class, 'savings'])->name('savings');
    Route::post('/savings/store', [AppController::class, 'saving_store'])->name('savings.store');
    Route::put('/savings/{saving}', [AppController::class, 'saving_update'])->name('savings.update');
    Route::post('/savings/{saving}/deposit', [AppController::class, 'saving_deposit'])->name('savings.deposit');
    Route::post('/savings/{saving}/withdraw', [AppController::class, 'saving_withdrawal'])->name('savings.withdraw');
    Route::delete('/savings/{saving}', [AppController::class, 'saving_destroy'])->name('savings.destroy');
    Route::get('/savings/{saving}/status', [AppController::class, 'getStatus']);

    // Informasi Diri
    Route::get('/settings', [AppController::class, 'setting'])->name('setting');
    Route::put('/settings', [AppController::class, 'profile_update'])->name('setting.update');
    Route::delete('/settings/{user}', [AuthController::class, 'destroy_user'])->name('setting.destroy');
});
