<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\FeeController;
use App\Http\Controllers\user\PageController;
use App\Http\Controllers\admin\FundController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\user\ProsesController;
use App\Http\Controllers\admin\LogoutController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\ReceiptController;
use App\Http\Controllers\admin\DonationController;
use App\Http\Controllers\admin\DashboardController;


Route::namespace('App\Http\Controllers\user')->group(function(){
    Route::get('/', [PageController::class, 'index'])->name('index');
    Route::get('tabung', [PageController::class, 'tabung'])->name('tabung');
    Route::get('detail/{id}', [PageController::class, 'detail'])->name('detail');
    Route::get('sumbang/{id}', [PageController::class, 'sumbang'])->name('sumbang');
    Route::get('return', [ProsesController::class, 'return'])->name('return');
    Route::get('callBack', [ProsesController::class, 'callBack'])->name('callBack');
    Route::post('pay', [ProsesController::class, 'pay'])->name('pay');
    Route::get('showReceipt', [ProsesController::class, 'showReceipt'])->name('showReceipt'); 
    Route::get('receipt', [ProsesController::class, 'receipt'])->name('receipt');

});

Route::middleware('guest')->namespace('App\Http\Controllers\user')->group(function(){   
    Route::get('/login',[PageController::class, 'login_user'])->name('login_user'); 
    Route::post('/login',[ProsesController::class, 'auth_user'])->name('auth_user');
});

Route::middleware('auth')->namespace('App\Http\Controllers\user')->group(function(){
    Route::get('pibg',[PageController::class, 'pibg'])->name('pibg');
    Route::get('akaun',[PageController::class, 'akaun'])->name('akaun');
    Route::get('edit', [PageController::class, 'edit'])->name('edit');
    Route::get('update',[PageController::class, 'update'])->name('update');
    Route::post('update/{id}', [ProsesController::class, 'update'])->name('update');
    Route::post('gambar/{id}', [ProsesController::class, 'gambar'])->name('gambar');
    Route::post('addG',[ProsesController::class, 'addG'])->name('addG');
    Route::delete('destroyG/{id}', [ProsesController::class, 'destroyG'])->name('destroyG');
    Route::post('addS',[ProsesController::class, 'addS'])->name('addS');
    Route::delete('destroyS/{id}', [ProsesController::class, 'destroyS'])->name('destroyS');
    Route::get('logoutt',[ProsesController::class, 'logout'])->name('logout_user');
});



Route::middleware('guest:admin')->namespace('App\Http\Controllers\admin')->prefix('admin')->group(function () {
    Route::get('/', [LoginController::class, 'login_admin'])->name('login_admin');
    Route::post('/auth', [LoginController::class, 'auth_admin'])->name('auth_admin');
    Route::get('/forgot_username', [LoginController::class, 'forgot_username'])->name('forgot_username');
    Route::get('/forgot_password', [LoginController::class, 'forgot_password'])->name('forgot_password');
    Route::post('/change_password', [LoginController::class, 'change_password'])->name('change_password');
    Route::get('/modify_password/{id}', [LoginController::class, 'modify_password'])->name('modify_password');
    
});

Route::middleware('auth:admin')->namespace('App\Http\Controllers\admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::post('/users', [UserController::class, 'create_user'])->name('create_user');
    Route::put('/users/{id}/activate', [UserController::class, 'activate'])->name('activate_user');
    Route::put('/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('deactivate_user');

    Route::get('/admins', [AdminController::class, 'admins'])->name('admins');
    Route::post('/admins', [AdminController::class, 'create_admin'])->name('create_admin');
    Route::put('/admins/{id}/activate', [AdminController::class, 'activate'])->name('activate_admin');
    Route::put('/admins/{id}/deactivate', [AdminController::class, 'deactivate'])->name('deactivate_admin');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile/{id}', [ProfileController::class, 'update_profile'])->name('update_profile');
    Route::get('/password', [ProfileController::class, 'password'])->name('password');
    Route::put('/password/{id}', [ProfileController::class, 'update_password'])->name('update_password');

    Route::get('/add_fund', [FundController::class, 'add_fund'])->name('add_fund');
    Route::post('/fund', [FundController::class, 'create_fund'])->name('create_fund');
    Route::get('/fund', [FundController::class, 'fund'])->name('fund');
    Route::get('/fund/{id}', [FundController::class, 'edit_fund'])->name('edit_fund');
    Route::put('/fund/{id}', [FundController::class, 'update_fund'])->name('update_fund');
    Route::delete('/fund/{id}', [FundController::class, 'delete_fund'])->name('delete_fund');
    Route::put('/fund/{id}/publish', [FundController::class, 'publish_fund'])->name('publish_fund');
    Route::put('/fund/{id}/conceal', [FundController::class, 'conceal_fund'])->name('conceal_fund');

    Route::get('/donation', [DonationController::class, 'donation'])->name('donation');
    Route::get('/donation/{id}', [DonationController::class, 'show_donation'])->name('show_donation');

    Route::get('/donation_receipt/{id}', [ReceiptController::class, 'donation_receipt'])->name('donation_receipt');

    Route::get('/donation_report', [ReportController::class, 'donation_report'])->name('donation_report');
    Route::get('/donation_report/{id}', [ReportController::class, 'generate_donation_report'])->name('generate_donation_report');

    Route::get('/fee', [FeeController::class, 'fee'])->name('fee');

    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});