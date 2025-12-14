<?php 

// app/Services/OrderService.php
namespace App\Services\Order;

use App\Models\Order\Order;
use App\Models\Auth_SuperVisor\MenuItem;
use App\Models\Auth_SuperVisor\MenuItemVariant;
use App\Models\Auth_SuperVisor\MenuItemAddon;
use App\Models\Order\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService {

    /**
     * Create a new order
     */
   public function createOrder(int $userId, array $items, ?int $tableId = null)
    {
        return DB::transaction(function () use ($userId, $items, $tableId) {

            // 1️⃣ Create Order FIRST
            // Fetch branch from table if exists, otherwise nullable (or enforced logic)
            // Assuming table belongs to a branch, so we get it from there.
             $branchId = null;
             if ($tableId) {
                 $table = \App\Models\Auth_SuperVisor\Table::find($tableId);
                 $branchId = $table ? $table->branch_id : null;
             }

            $order = Order::create([
                'user_id' => $userId,
                'table_id' => $tableId,
                'branch_id' => $branchId,
                'status' => 'pending',
                'payment_status' => 'pending',
                'total_price' => 0
            ]);

            $totalPrice = 0;

            // 2️⃣ Create Order Items
            foreach ($items as $item) {

                // 🔥 FETCH VARIANT PRICE
                $variant = MenuItemVariant::findOrFail($item['variant_id']);

                $itemPrice = $variant->price * $item['quantity'];

                $orderItem = $order->items()->create([
                    'menu_item_id' => $item['menu_item_id'],
                    'variant_id'   => $variant->id,
                    'quantity'     => $item['quantity'],
                    'price'        => $variant->price, // ✅ NEVER NULL
                ]);

                // 3️⃣ Add Addons (optional)
                if (!empty($item['addons'])) {
                    foreach ($item['addons'] as $addonData) {
                        $addon = MenuItemAddon::findOrFail($addonData['addon_id']);

                        $addonTotal = $addon->price * $addonData['quantity'];

                        $orderItem->addons()->create([
                            'menu_item_addon_id' => $addon->id, // Correct column
                            'quantity' => $addonData['quantity'],
                            'price'    => $addon->price,
                            // 'menu_item_id' => ... removed, not needed in this table
                        ]);

                        $itemPrice += $addonTotal;
                    }
                }

                $totalPrice += $itemPrice;
            }

            // 4️⃣ Update Order Total
            $order->update([
                'total_price' => $totalPrice
            ]);

            return $order->load(['items.addons']);
        });
    }

    /**
     * Update an existing order
     */
    public function updateOrder(Order $order, array $data): Order
    {
        // Update basic order data
        if (isset($data['status'])) {
            $order->status = $data['status'];
        }

        if (isset($data['payment_status'])) {
            $order->payment_status = $data['payment_status'];
        }

        if (isset($data['table_id'])) {
            $order->table_id = $data['table_id'];
        }

        $order->save();

        // Optional: update items if provided
        if (!empty($data['items'])) {
            $order->items()->delete();
            foreach ($data['items'] as $item) {
                $menuItem = MenuItem::findOrFail($item['menu_item_id']);
                $order->items()->create([
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $item['quantity'],
                    'price' => $menuItem->price
                ]);
            }
        }

        return $order->load('items', 'table');
    }

}
