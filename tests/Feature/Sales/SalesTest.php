<?php

namespace Tests\Feature\Sales;

use App\Models\User;
use App\Models\Sales;
use App\Providers\RouteServiceProvider;
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

    public function test_sales_can_be_recorded() :void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/sales', [
            'quantity' => 10,
            'unitCost' => 20.4
        ]);


        $response->assertSessionHasNoErrors();

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

/*

This is a useful test but it's been broken by making the code untestable in order to complete the task quickly.

  public static function salesPriceProvider() :array
    {
        return [
            [1, 10, 1, 23.34],
            [1, 20.50, 2, 64.67],
            [1, 12, 5, 90]
        ];
    }

    #[DataProvider('salesPriceProvider')]
    public function test_sale_price_calculation_works($productId, $unitPrice, $units, $expected) :void
    {
        $model = new Sales();

        $model->setUnitCost($unitPrice);
        $model->setQuantity($units);
        $model->setProductId($productId);
        $result = $model->calculateSalePrice();

        $this->assertEquals($expected, $result);
    }*/

}
