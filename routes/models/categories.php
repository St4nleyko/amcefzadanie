<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/createcategory', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/storecategory', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/editcategory/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/updatecategory/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/deletecategory/{category}', [CategoryController::class, 'destroy'])->withTrashed()->name('category.delete');

