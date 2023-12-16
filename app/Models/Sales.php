<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'unitCost',
        'salesPrice'
    ];

    protected $table = 'sales_ledger';

    private float $unitPrice;
    private int $units;

    public function setUnitPrice($price) :void
    {
        $this->unitPrice = $price;
    }

    public function setUnits($qty) :void
    {
        $this->units = $qty;
    }

    public function calculateSalePrice() :float
    {
        $cost = $this->units * $this->unitPrice;
        // The following would be better as class constants or even configuration variables in a production system
        $profitMargin = 0.25;
        $shippingCost = 10.00;

        // the addition of the addition 0.004 causes number format to always round up the pennies
        return number_format(($cost / (1 - $profitMargin) + $shippingCost) + 0.004, 2);
    }

    public function save(array $options = [])
    {
        $this->quantity = $this->units;
        $this->unitCost = $this->unitPrice;
        $this->salesPrice = $this->calculateSalePrice();
        parent::save($options);
    }

}
