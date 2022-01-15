<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminsController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [AdminsController::class, 'index'])->name('admin.index');
