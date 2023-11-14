<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\UserController;

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

// login, register
Route::middleware(['admin_auth'])->group(function() {
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});


Route::middleware([
    'auth'
])->group(function () {
    // dashboard
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // admin
    Route::middleware(['admin_auth'])->group(function() {
        // category
        Route::prefix('category')->group(function() {
            Route::get('/list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('/create/page', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('/create', [CategoryController::class, 'create'])->name('category#create');
            Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
            Route::get('/edit/page/{id}', [CategoryController::class, 'editPage'])->name('category#editPage');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category#update');
        });

        // profile
        Route::prefix('admin')->group(function() {
            Route::get('/changePassword/page', [AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('/change/password', [AdminController::class, 'changePassword'])->name('admin#changePassword');
            Route::get('/profile/details', [AdminController::class, 'details'])->name('admin#details');
            Route::get('/profile/edit', [AdminController::class, 'edit'])->name('admin#edit');
            Route::post('/profile/update/{id}', [AdminController::class, 'update'])->name('admin#update');

            // admin account delete
            Route::get('list', [AdminController::class, 'list'])->name('admin#list');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admin#delete');
            Route::get('demote/{id}', [AdminController::class, 'demote'])->name('admin#demote');
            Route::get('create/page', [AdminController::class, 'createPage'])->name('admin#createPage');
            Route::post('create', [AdminController::class, 'create'])->name('admin#create');
        });

        // product
        Route::prefix('product')->group(function() {
            Route::get('/list', [ProductController::class, 'list'])->name('product#list');
            Route::get('/create/page', [ProductController::class, 'createPage'])->name('product#createPage');
            Route::post('/create', [ProductController::class, 'create'])->name('product#create');
            Route::get('/delete/{id}/{image}', [ProductController::class, 'delete'])->name('product#delete');
            Route::get('edit/page/{id}', [ProductController::class, 'editPage'])->name('product#editPage');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('product#update');
        });
    });




    // user
    // home
    // Route::group([
    //     'prefix' => 'user',
    //     'middleware' => 'user_auth'
    //     ], function() {
    //     Route::get('/home', function() {
    //         return view('user.home');
    //     })->name('user#home');
    // });\

    // user
    Route::middleware(['user_auth'])->group(function() {
        // home
        Route::prefix('user')->group(function() {
            Route::get('/home', [UserController::class, 'home'])->name('user#home');
        });
    });
});






