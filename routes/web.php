<?php

use App\Http\Controllers\Backend\ProductBackendController;
use App\Http\Controllers\Frontend\IndexController;
use Illuminate\Support\Facades\Route;

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

// Route::get('', function () {
//     return view('welcome');
// });

Route::prefix('')->group(function() {
    Route::get('/', [IndexController::class, 'indexHome']);
    Route::get('/products', [IndexController::class, 'listProduct']);
    Route::get('/cart', [IndexController::class, 'listCarts']);
    Route::get('/checkout', [IndexController::class, 'checkout']);
});

Route::prefix('backend')->group(function () {
    Route::get("/", function() {
        return "LOVE YOU NANSAY ";
    });
    Route::resource('product', ProductBackendController::class);
});