<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;

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

        // order
        Route::prefix('order')->group(function() {
            Route::get('/list', [OrderController::class, 'list'])->name('admin#orderList');
            Route::post('/status/ajax', [OrderController::class, 'ajaxStatus'])->name('admin#ajaxStatus');
            Route::post('/ajax/change/status', [OrderController::class, 'ajaxChangeStatus'])->name('admin#ajaxChangeStatus');
            Route::get('listInfo/{id}', [OrderController::class, 'listInfo'])->name('admin#listInfo');
        });

        // user
        Route::prefix('user')->group(function() {
            Route::get('/list', [AdminController::class, 'userList'])->name('admin#userList');
            Route::get('/promote/{id}', [AdminController::class, 'promoteAdmin'])->name('admin#promote');
            Route::get('delete/{id}', [AdminController::class, 'deleteUser'])->name('admin#deleteUser');
        });
    });



    // user
    Route::middleware(['user_auth'])->group(function() {
        // home
        Route::prefix('user')->group(function() {
            Route::get('/home', [UserController::class, 'home'])->name('user#home');
            Route::get('/filter/{id}', [UserController::class, 'filter'])->name('user#filter');
            Route::get('order/history', [UserController::class, 'history'])->name('user#history');

            Route::prefix('pizza')->group(function() {
                Route::get('/details/{id}', [UserController::class, 'pizzaDetails'])->name('user#pizzaDetails');

            });

            Route::prefix('cart')->group(function() {
                Route::get('/list', [UserController::class, 'cartList'])->name('user#cartList');

            });

            Route::prefix('password')->group(function() {
                Route::get('/change', [UserController::class, 'changePasswordPage'])->name('user#changePasswordPage');
                Route::post('/change', [UserController::class, 'changePassword'])->name('user#changePassword');
            });

            Route::prefix('profile')->group(function() {
                Route::get('/edit', [UserController::class, 'editProfile'])->name('user#editProfilePage');
                Route::post('/update/{id}', [UserController::class, 'updateProfile'])->name('user#updateProfile');
            });


                Route::prefix('ajax')->group(function() {
                    Route::post('product/list', [AjaxController::class, 'productList'])->name('ajax#productList');
                    Route::post('/addToCart', [AjaxController::class, 'addToCart'])->name('ajax#addToCart');
                    Route::post('/update/cart', [AjaxController::class, 'updateCart'])->name('ajax#updateCart');
                    Route::post('delete/item', [AjaxController::class, 'deleteItem'])->name('ajax#deleteItem');
                    Route::post('order', [AjaxController::class, 'order'])->name('ajax#order');
                    Route::post('increase/viewCount', [AjaxController::class, 'increaseViewCount'])->name('ajax#increaseViewCount');
                });

        });
    });
});






