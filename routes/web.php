<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProducteController;

Route::get('/', [ProducteController::class, 'index'])->name('home');
Route::get('/register', [ProducteController::class, 'showForm'])->name('register.form');
Route::post('/register', [ProducteController::class, 'registerProduct'])->name('register.store');
Route::get('/xml', [ProducteController::class, 'showXml'])->name('xml.show');
Route::get('/json', [ProducteController::class, 'showJson'])->name('json.show');