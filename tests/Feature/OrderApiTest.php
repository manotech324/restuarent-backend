<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin\Branch;
use App\Models\Auth_SuperVisor\Table;
use App\Models\Auth_SuperVisor\MenuCategory;
use App\Models\Auth_SuperVisor\MenuItem;
use App\Models\Auth_SuperVisor\MenuItemVariant;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $branch;
    protected $table;
    protected $menuItem;
    protected $variant;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create User & Token
        $this->user = User::factory()->create(['role' => 'waiter']);
        $this->token = JWTAuth::fromUser($this->user);

        // 2. Create Setup (Branch, Table, Menu)
        $this->branch = Branch::factory()->create();
        $this->table = Table::factory()->create(['branch_id' => $this->branch->id]);

        $category = MenuCategory::factory()->create(['branch_id' => $this->branch->id]);
        $this->menuItem = MenuItem::factory()->create([
            'category_id' => $category->id,
            'branch_id' => $this->branch->id
        ]);
        
        $this->variant = MenuItemVariant::factory()->create([
            'menu_item_id' => $this->menuItem->id,
            'price' => 100.00
        ]);
    }

    /** @test */
    public function it_can_create_an_order()
    {
        $payload = [
            'user_id' => $this->user->id,
            'table_id' => $this->table->id,
            'items' => [
                [
                    'menu_item_id' => $this->menuItem->id,
                    'variant_id' => $this->variant->id,
                    'quantity' => 2,
                    'addons' => []
                ]
            ]
        ];

        $response = $this->withHeaders(['Authorization' => "Bearer $this->token"])
                         ->postJson('/api/orders', $payload);

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);

        // Use loose comparison for price
        $this->assertEquals(200.00, $response->json('order.total_price'));

        $response->assertJsonPath('order.branch_id', $this->branch->id); // Auto-assigned
    }

    /** @test */
    public function it_can_add_items_to_existing_order()
    {
        // 1. Create initial order
        $createPayload = [
            'user_id' => $this->user->id,
            'table_id' => $this->table->id,
            'items' => [
                [
                    'menu_item_id' => $this->menuItem->id,
                    'variant_id' => $this->variant->id,
                    'quantity' => 1, // Price: 100
                    'addons' => []
                ]
            ]
        ];

        $createResponse = $this->withHeaders(['Authorization' => "Bearer $this->token"])
                               ->postJson('/api/orders', $createPayload);

        $orderId = $createResponse->json('order.id');

        // 2. Add new item
        $addPayload = [
            'items' => [
                [
                    'menu_item_id' => $this->menuItem->id,
                    'variant_id' => $this->variant->id,
                    'quantity' => 2, // Price: 200
                    'addons' => []
                ]
            ]
        ];

        $updateResponse = $this->withHeaders(['Authorization' => "Bearer $this->token"])
                               ->postJson("/api/orders/{$orderId}/items", $addPayload);

        $updateResponse->assertStatus(200)
                       ->assertJsonPath('success', true);
        
        // Use loose comparison for price
        $this->assertEquals(300.00, $updateResponse->json('order.total_price'));
    }
}
