<?php

use App\Http\Controllers\ToDoItemController;
use Illuminate\Support\Facades\Route;

    Route::get('/todoitems', [ToDoItemController::class, 'index'])->name('todoitem.index');
    Route::get('/createtodoitem', [ToDoItemController::class, 'create'])->name('todoitem.create');
    Route::post('/storetodoitem', [ToDoItemController::class, 'store'])->name('todoitem.store');
    Route::get('/edititem/{toDoItem}', [ToDoItemController::class, 'edit'])->name('todoitem.edit');
    Route::post('/updatetodoitem/{toDoItem}', [ToDoItemController::class, 'update'])->name('todoitem.update');
    Route::post('/completeitem/{toDoItem}', [ToDoItemController::class, 'complete'])->name('todoitem.complete');
    Route::post('/deleteitem/{toDoItem}/{isDestroy}', [ToDoItemController::class, 'destroyHandler'])->withTrashed()->name('todoitem.delete');
