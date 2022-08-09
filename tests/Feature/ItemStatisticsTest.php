<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemStatisticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_getting_stats_items(): void
    {
        Item::factory()->amazon()->create(['created_at' => now()->subMonths(1), 'price' => 100]);
        Item::factory()->zid()->create(['created_at' => now()->subMonths(1), 'price' => 200]);

        $response = $this->getJson('/statistics/items');

        $response->assertStatus(200);

        $data = \json_decode($response->getContent());

        $this->assertEquals(2, $data->data->count);
        $this->assertEquals(number_format(150, 2, '.', ' '), $data->data->avg);
        $this->assertSame("zid.store", $data->data->website_max_price);
        $this->assertEquals(0, $data->data->price_in_current_month);
    }

    public function test_getting_stats_total_price_this_month(): void
    {
        Item::factory()->zid()->create(['created_at' => now()->subMonths(1), 'price' => 200]);
        Item::factory()->amazon()->create(['created_at' => now()->subMonths(1), 'price' => 100]);

        // items added in this month
        Item::factory()->zid()->create(['price' => 500]);
        Item::factory()->zid()->create(['price' => 500]);

        $response = $this->getJson('/statistics/items?type=price_in_current_month');

        $response->assertStatus(200);

        $data = \json_decode($response->getContent());

        $this->assertEquals(number_format(1000, 2, '.', ' '), $data->data->price_in_current_month);
    }
}
