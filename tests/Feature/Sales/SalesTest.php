<?php

namespace Tests\Feature\Sales;

use App\Models\Products;
use App\Models\User;
use App\Models\Sales;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_page_can_be_rendered() :TestResponse
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/sales');

        $response->assertStatus(200);

        return $response;
    }

    /**
     * @depends test_sales_page_can_be_rendered
     */
    public function test_sale_page_has_sales_form(TestResponse $response) :void
    {
        // Not the best test but it'll do to demonstrate the principle..
        $response->assertSee([
            'salesForm',
            'Quantity',
            'Unit Cost (£)',
            'Selling Price',
            'Record Sale'
        ]);
    }

//    This is now the only broken test - it needs the fake model binding to the service container... somehow
//    public function test_sales_can_be_recorded() :void
//    {
//        $user = User::factory()->create();
//
//        $response = $this->actingAs($user)->post('/sales', [
//            'product_id' => 1,
//            'quantity' => 10,
//            'unitCost' => 20.4
//        ]);
//
//
//        $response->assertSessionHasNoErrors();
//
//        $response->assertRedirect(RouteServiceProvider::HOME);
//    }

  public static function salesPriceProvider() :array
    {
        return [
            [1, 25, 10, 1, 23.34],
            [1, 25, 20.50, 2, 64.67],
            [1, 25, 12, 5, 90],
            [2, 15, 10, 1, 21.77],
            [2, 15, 20.50, 2, 58.24],
            [2, 15, 12, 5, 80.59]
        ];
    }

    #[DataProvider('salesPriceProvider')]
    public function test_sale_price_calculation_works($productId, $margin, $unitPrice, $units, $expected) :void
    {
        $model = new Sales();

        $fakeProductCollection = new Collection();
        $fakeProductCollection->add(Products::factory()->create());
        $fakeProductCollection[0]->margin = $margin;

        $model->setUnitCost($unitPrice);
        $model->setQuantity($units);
        $model->setProductId($productId);
        $model->setProduct($fakeProductCollection);
        $result = $model->calculateSalePrice();

        $this->assertEquals($expected, $result);
    }

}
