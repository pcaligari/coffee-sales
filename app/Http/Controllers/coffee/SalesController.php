<?php

namespace App\Http\Controllers\coffee;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $sales = DB::table('sales_ledger', 's')->select(
            [
                'products.name',
                's.quantity',
                's.unitCost',
                's.salesPrice'
            ]
        )->join(
            'products', 's.product_id', '=', 'products.id'
        )->get();
        
        return view('coffee_sales',['ledger' => $sales]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'quantity' => ['required'],
            'unitCost' => ['required']
        ]);

        $sale = new Sales();

        $sale->setQuantity($request->quantity);
        $sale->setUnitCost($request->unitCost);

        $sale->save();
        return redirect(RouteServiceProvider::HOME);
    }

}

