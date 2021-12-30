<?php

use App\Http\Controllers\Backend\ProductBackendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;

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
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::prefix('')->group(function() {
    Route::get('/', [IndexController::class, 'indexHome']);
    Route::get('/products', [IndexController::class, 'listProduct']);
    Route::get('/cart', [IndexController::class, 'listCarts']);
    Route::get('/checkout', [IndexController::class, 'checkout']);
    Route::get('/product/detail/{id?}', [IndexController::class, 'detailProduct']);
});

Route::prefix('backend')->group(function () {
    Route::get("/login", function() {
        return view("frontend.pages.login");
    });
    Route::middleware(['authAdmin'])->group(function() {
        Route::get("/", function() {
            return view("welcome");
        });
        Route::resource('product', ProductBackendController::class);
    });
});