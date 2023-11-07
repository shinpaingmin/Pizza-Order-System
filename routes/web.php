<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

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
        });
    });




    // user
    // home
    Route::group([
        'prefix' => 'user',
        'middleware' => 'user_auth'
        ], function() {
        Route::get('/home', function() {
            return view('user.home');
        })->name('user#home');
    });
});






