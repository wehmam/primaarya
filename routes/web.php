<?php

use App\Http\Controllers\Backend\AuthLoginController;
use App\Http\Controllers\Backend\CategoryBackendController;
use App\Http\Controllers\Backend\ProductBackendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return redirect(url('/login'));
});

require __DIR__.'/auth.php';


Route::prefix('')->group(function() {
    Route::get('/', [IndexController::class, 'indexHome']);
    Route::get('/products', [IndexController::class, 'listProduct']);
    Route::get('/products/{slug}', [IndexController::class, 'listProductSlug']);
    Route::get('/product/detail/{id?}', [IndexController::class, 'detailProduct']);

    Route::middleware(['auth'])->group(function () {
        Route::prefix("cart")->group(function () {
            Route::get('/', [IndexController::class, 'listCarts']);
            Route::post('/order', [IndexController::class, 'addToCarts']);
        });
        Route::get('/checkout', [IndexController::class, 'checkout']);     
        Route::post('/checkout', [IndexController::class, 'checkoutPost']);
    });
});

Route::prefix('backend')->group(function () {
    Route::get("/login", [AuthLoginController::class, 'index'])->middleware('guestAdmin');
    Route::post("/login", [AuthLoginController::class, 'loginPost']);
    Route::middleware(['authAdmin'])->group(function() {
        Route::get("/", function() {
            return view("backend.pages.dashboard");
        });
        Route::post("/logout", [AuthLoginController::class, 'logout']);
        Route::resource('product', ProductBackendController::class);
        Route::delete('/product/delete-photo/{id}', [ProductBackendController::class, 'deletePhotoById']);
        Route::resource('category', CategoryBackendController::class);
    });
});