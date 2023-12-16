<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Coffee\SalesController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::redirect('/dashboard', '/sales');

Route::controller(SalesController::class)->group(function () {
    Route::get('/sales', 'show')->name('coffee.sales');
    Route::post('/sales', 'save')->name('record.sales');
})->middleware(['auth'])->name('shop');

Route::get('/shipping-partners', function () {
    return view('shipping_partners');
})->middleware(['auth'])->name('shipping.partners');

require __DIR__.'/auth.php';
