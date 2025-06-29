<?php

use App\Http\Controllers\AuthController;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Dashboard sebagai halaman utama
// Dashboard sebagai halaman
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Route login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Route forgot password
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Route reset password
Route::get('/reset-password/{token}', function ($token) {
    return view('reset_password', ['token' => $token, 'email' => request('email')]);
})->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Resource Routes
Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class);
Route::resource('transactions', TransactionController::class);
Route::resource('penjualan', PenjualanController::class);

// API Routes
Route::get('/api/products/{id}', [ProductController::class, 'getProduct']);

// Route POST /logout untuk proses logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect GET /logout agar tidak 404
Route::get('/logout', function () {
    return redirect('/login');
});
