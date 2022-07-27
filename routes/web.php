<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;



Route::get('/', [TestController::class, 'index']);


Route::get('/admin', [PageController::class, 'index']);
Route::post('/uploadFile', [PageController::class, 'uploadFile'])->name('uploadFile');


Route::post('/store', [ProductController::class, 'store'])->name('store');
Route::get('/fetchall', [ProductController::class, 'fetchAll'])->name('fetchAll');
Route::delete('/delete', [ProductController::class, 'delete'])->name('delete');
Route::get('/edit', [ProductController::class, 'edit'])->name('edit');
Route::post('/update', [ProductController::class, 'update'])->name('update');

