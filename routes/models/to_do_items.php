<?php

use App\Http\Controllers\ToDoItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/todoitems', [ToDoItemController::class, 'index'])->name('todoitem.index');
    Route::get('/createtodoitem', [ToDoItemController::class, 'create'])->name('todoitem.create');
    Route::post('/storetodoitem', [ToDoItemController::class, 'store'])->name('todoitem.store');
    Route::get('/edititem/{toDoItem}', [ToDoItemController::class, 'edit'])->name('todoitem.edit');
    Route::post('/updatetodoitem/{toDoItem}', [ToDoItemController::class, 'update'])->name('todoitem.update');
    Route::post('/completeitem/{toDoItem}', [ToDoItemController::class, 'complete'])->name('todoitem.complete');
    Route::post('/deleteitem/{toDoItem}/{isDestroy}', [ToDoItemController::class, 'destroyHandler'])->withTrashed()->name('todoitem.delete');

});
