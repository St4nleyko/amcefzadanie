<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//authenticated users
Route::group(['middleware' => ['auth']], function () {
    //common users
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/myprofile', [UserController::class, 'myProfile'])->name('myprofile');
    Route::post('/updatemyprofile/{id}', [UserController::class, 'updateMyProfile'])->name('update.myprofile');

    // superadmin routes
    Route::group(['middleware' => ['role:superAdmin']], function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('role');
        Route::get('/addrole', [RoleController::class, 'addRole'])->name('add.role');
        Route::post('/storerole', [RoleController::class, 'storeRole'])->name('store.role');
        Route::get('/editrole/{id}', [RoleController::class, 'editRole'])->name('edit.role');
        Route::post('/updaterole/{id}', [RoleController::class, 'updateRole'])->name('update.role');
        Route::post('/deleterole/{id}', [RoleController::class, 'deleteRole'])->name('delete.role');
    });

    // admin and superadmin routes
    Route::group(['middleware' => ['role:superAdmin|admin']], function () {
        Route::get('/users', [UserController::class, 'indexUser'])->name('index.user');
        Route::get('/edituser/{id}', [UserController::class, 'editUser'])->name('edit.user');
        Route::post('/updateuser/{id}', [UserController::class, 'updateUser'])->name('update.user');
        Route::post('/deleteuser/{id}', [UserController::class, 'deleteUser'])->name('delete.user');
        Route::get('/createuser', [UserController::class, 'createUser'])->name('create.user');
        Route::post('/storeuser', [UserController::class, 'storeUser'])->name('store.user');
    });

    //models routes
    include 'models/categories.php';
    include 'models/to_do_items.php';
});
