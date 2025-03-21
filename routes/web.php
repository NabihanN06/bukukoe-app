<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Book Routes - Admin Only
Route::middleware(['auth', 'admin'])->name('book.')->prefix('/book')->group(function () {
    Route::get('/', [BookController::class,'index'])->name('index'); // book.index
    Route::get('/new', [BookController::class,'create'])->name('create'); // book.create-book
    Route::post('/new', [BookController::class,'store'])->name('store');

    // Route show excluded from admin
    Route::get('/{slug}', [BookController::class,'show'])->name('show')->withoutMiddleware('admin');
    
    Route::get('/edit/{slug}', [BookController::class,'edit'])->name('edit');
    Route::post('/edit/{slug}', [BookController::class,'update'])->name('update');
    Route::delete('/delete/{id}', [BookController::class,'destroy'])->name('delete');
});

// Dashboard Routes
Route::middleware(['auth'])->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('index');
    Route::get('/borrow/{slug}', [DashboardController::class,'borrow'])->name('borrow');
});

// Borrow Routes
Route::middleware(['auth'])->name('borrow.')->group(function () {
    Route::post('/borrow/{id}', [BorrowController::class,'request'])->name('request');
    Route::patch('/borrow/accept', [BorrowController::class, 'accept'])->name('accept');
    Route::patch('/borrow/reject', [BorrowController::class,'reject'])->name('reject');
    Route::patch('/borrow/return', [BorrowController::class,'return'])->name('return'); // Tambahkan route ini
});

// Auth Routes
Route::get('/sign-up', [UserController::class, 'signupForm'])->name('sign-up-form');
Route::post('/sign-up', [UserController::class,'register'])->name('register');
Route::get('/sign-in', [UserController::class,'signinForm'])->name('sign-in-form');
Route::post('/sign-in', [UserController::class,'login'])->name('login');
Route::post('/sign-out', [UserController::class,'logout'])->name('logout');