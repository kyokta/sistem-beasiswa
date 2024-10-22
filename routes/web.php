<?php

use App\Http\Controllers\BeasiswaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [BeasiswaController::class, 'index'])->name('index');
Route::get('/daftar', [BeasiswaController::class, 'daftar'])->name('daftar');
Route::get('/hasil', [BeasiswaController::class, 'hasil'])->name('hasil');
Route::post('/store-beasiswa', [BeasiswaController::class, 'storeBeasiswa'])->name('store-beasiswa');
Route::post('/store-mahasiswa', [BeasiswaController::class, 'storeMahasiswa'])->name('store-mahasiswa');