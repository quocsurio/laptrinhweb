<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;



Route::get('login', [CustomAuthController::class, 'toLogin'])->name('login');
Route::get('signout', [CustomAuthController::class, 'signout'])->name('signout');
Route::get('register', [CustomAuthController::class, 'toRegister'])->name('register');
Route::post('register', [CustomAuthController::class, 'createUser'])->name('user.createUser');
Route::post('login', [CustomAuthController::class, 'checkUser'])->name('user.checkUser');
Route::get('home', [CustomAuthController::class, 'listUser'])->name('home');
Route::get('delete', [CustomAuthController::class, 'deleteUser'])->name('user.delete');
Route::get('item', [CustomAuthController::class, 'showinfo'])->name('user.show');
Route::get('edit', [CustomAuthController::class, 'editUser'])->name('user.edit');
Route::post('edit', [CustomAuthController::class, 'cfeditUser'])->name('user.update');
Route::get('post', [CustomAuthController::class, 'getpost'])->name('user.posts');
Route::get('/', function () {
    return view('auth.login');
});