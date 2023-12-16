<?php

namespace App\Http\Controllers\coffee;

use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('coffee_sales');
    }

}
