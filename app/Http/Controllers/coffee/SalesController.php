<?php

namespace App\Http\Controllers\coffee;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $sales = Sales::all();

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

