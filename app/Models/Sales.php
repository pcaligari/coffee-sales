<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'quantity',
        'unitCost',
        'salesPrice'
    ];

    protected $table = 'sales_ledger';

    public function setUnitCost($price) :void
    {
        $this->unitCost = $price;
    }

    public function setQuantity($qty) :void
    {
        $this->quantity = $qty;
    }

    public function setProductId($productId) {
        $this->product_id = $productId;
    }

    public function calculateSalePrice() :float
    {
        $cost = $this->quantity * $this->unitCost;

        // Lets query directly and break the tests - should be using a model class for this
        $product = DB::table('products', 'p')->select(
            [
                'p.margin'
            ]
        )->where(
            'id', '=', $this->product_id
        )->get();

        $profitMargin = $product[0]->margin / 100;

        // The following would be better as class constants or even configuration variables in a production system
        $shippingCost = 10.00;

        // the addition of the addition 0.004 causes number format to always round up the pennies
        return number_format(($cost / (1 - $profitMargin) + $shippingCost) + 0.004, 2);
    }

    public function save(array $options = [])
    {
        $this->salesPrice = $this->calculateSalePrice();
        parent::save($options);
    }

}
