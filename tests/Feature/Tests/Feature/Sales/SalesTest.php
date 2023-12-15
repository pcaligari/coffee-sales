<?php

namespace Tests\Feature\Sales;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_page_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/sales');

        $response->assertStatus(200);
    }

    public function test_sales_can_be_recorded()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/sales', [
            'quantity' => 10,
            'unit-cost' => 20.4
        ]);

        //$response->dump();

        $response->assertSessionHasNoErrors();
    }

}
