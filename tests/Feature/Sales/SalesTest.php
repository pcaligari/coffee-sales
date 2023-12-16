<?php

namespace Tests\Feature\Sales;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
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
            'unit-cost' => 20.4
        ]);


        $response->assertSessionHasNoErrors();
    }

}
