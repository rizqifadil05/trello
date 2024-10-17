<?php

use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/data-obat')->name('data_obat.')->group(function() {
    Route::get('/data', [ProductController::class, 'index'])->name('data');
    Route::get('/tambah', [ProductController::class, 'create'])->name('tambah');
    Route::post('/tambah/proses', [ProductController::class, 'store'])->name('tambah.proses');
    Route::get('/ubah/{id}', [ProductController::class, 'edit'])->name('ubah');
    Route::patch('/ubah/{id}/proses', [ProductController::class, 'update'])->name('ubah.proses');
    Route::delete('/hapus/{id}', [ProductController::class, 'destroy'])->name('hapus');
    Route::patch('/ubah/stok/{id}', [ProductController::class, 'updateStock'])->name('ubah.stok');
});
