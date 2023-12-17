<?php

use App\Models\Sales;
use Illuminate\Http\Request;
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

// Could be moved to an include file, same as auth
Route::controller(SalesController::class)->group(function () {
    Route::get('/sales', 'show')->name('coffee.sales');
    Route::post('/sales', 'save')->name('record.sales');
})->middleware(['auth'])->name('shop');

Route::get('/getPrice', function (Request $request) {

    $sale = new Sales();

    $sale->setQuantity($request->units);
    $sale->setUnitCost($request->unitCost);
    $sale->setProductId($request->product);

    return response($sale->calculateSalePrice(), 200)->header('Content-Type', 'text/plain');

});

Route::get('/shipping-partners', function () {
    return view('shipping_partners');
})->middleware(['auth'])->name('shipping.partners');

require __DIR__.'/auth.php';
