<?php

namespace App\Http\Controllers\coffee;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Sales;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{

    private Products $products;

    public function __construct(Products $products)
    {
       $this->products = $products;
    }

    /**
     * Show the coffee sales view.
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
            'product_id' => ['required'],
            'quantity' => ['required'],
            'unitCost' => ['required']
        ]);

        $product = $this->getProducts();
        $product = $product::where(
            'id', $request->product_id
        )->get();

        $sale = new Sales();

        $sale->setProductId($request->product_id);
        $sale->setQuantity($request->quantity);
        $sale->setUnitCost($request->unitCost);
        $sale->setProduct($product);

        $sale->save();
        return redirect(RouteServiceProvider::HOME);
    }

    public function getProducts(): Products
    {
        return $this->products;
    }

    public function setProducts(Products $products): void
    {
        $this->products = $products;
    }

}

