<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class add_products extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Original Product
        DB::table('products')->insert([
            'name' => 'Gold Coffee',
            'margin' => 25
        ]);
        // New Product
        DB::table('products')->insert([
            'name' => 'Arabic Coffee',
            'margin' => 15
        ]);

        // Link Existing Sales to original product
        DB::table('sales_ledger')->update(['product_id' => 1]);
    }
}
